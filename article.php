<?php
	require_once('includes/header.php'); 
	
	//If the Form is filled
	if(var_post('titre')){
		$titre=mysql_real_escape_string(var_post('titre')); //POST of Title
		$texte=mysql_real_escape_string(var_post('texte')); //POST of Text
		$tag=mysql_real_escape_string(var_post('tag')); //Post of tag
		$counttag=mysql_real_escape_string(var_post('counttag')); //POST of the count of the tags from the articles which is going to be edit
		$ancientag=mysql_real_escape_string(var_post('ancientag')); //POST of the tag before the editing of the tag of the article
		
		//If the adress contain the id of an article
		if(var_post('id')){ 
			$id=mysql_real_escape_string($_POST['id']); //retrieving the id of the article with POST
			$sql="UPDATE articles SET titre='".$titre."',texte='".$texte."' WHERE id='".$id."'"; //Updating the article with the FORM retrieved with POST method
			
			//It move the file selected from the source to the destination and rename it on "id of the article".jpg
			$src = $_FILES['image']['tmp_name'];
			$dest = dirname(__FILE__)."/data/images/$id.jpg";
			move_uploaded_file($src,$dest);
			
			//If the new tag is the same than the ancient one, there is no reason to Update the table
			if ($tag != $ancientag){
				$sqltag ="SELECT * FROM tags WHERE nom = ('".$tag."')";
				$data = mysql_fetch_array(mysql_query($sqltag));	//The query check if the new tag written in the form already exist is the form
				
				//If the tag doesn't exist, he is created
				if ($data == false){	
					$sqltagfalse = "INSERT INTO tags (id_tag,nom) VALUES ('','".($tag)."')";
					mysql_query($sqltagfalse);
				}
				
				//The query retrieve the id_tag of the new selected tag
				$sqlnewtag = "Select id_tag FROM tags WHERE nom =('".($tag)."') ORDER BY id_tag DESC LIMIT 0,1";
				$data_idtag = mysql_fetch_array(mysql_query($sqlnewtag));
				$id_tag = $data_idtag["id_tag"];

				//Then it bound the id_tag with the id_article(of the modifed article) on the tags_articles table
				$sqlbound = "UPDATE tags_articles SET  id_tags = '".$id_tag."' WHERE id_articles = '".$id."'";
				mysql_query($sqlbound);
				
				//If the ancient tag is replaced,the tag is counted how many time it has been used on the table tags_articles before the article get modified
				//If the counttag == '1' it means that the previous tag were used only by this article and got replaced, which mean that he will have to be deleted from the table
				if($counttag == '1'){ 
					$sqlsupptag = "DELETE FROM tags WHERE nom = '".$ancientag."'";
					mysql_query($sqlsupptag);
				}	
			}
			
			requete_notif($sql,'article','modifier'); //Notification about the success of the editing
			header('Location:index.php'); //redirection to the index.php
			exit();
			
		 //If there is no article id on the dress bar	
		 //BUT the form is filled
		}else { 
			//The query create a new article and fill it with the form values
			$sql="INSERT INTO articles (titre, texte, date) VALUES('".$titre."','".$texte."',UNIX_TIMESTAMP())"; 
			requete_notif($sql,'article','ajouter');
		
			//The query retrieve the id of the last article created
			$sqlid= "SELECT id FROM articles ORDER BY id DESC LIMIT 0,1";
			$data=mysql_fetch_array(mysql_query($sqlid));
			$id=$data['id']; //the id of the last article created is stocked
			$src = $_FILES['image']['tmp_name'];
			$dest = dirname(__FILE__)."/data/images/$id.jpg";
			//then the image is placed in the folder for the images of the websites and named with the id of the article in which the image will appear
			move_uploaded_file($src,$dest);
		
			//The query check if the tag written in the form already exist is the form
			$sqltag ="SELECT * FROM tags WHERE nom = ('".$tag."')";
			$data = mysql_fetch_array(mysql_query($sqltag));
			
			//IF tag doesn't exist then he is created
			if ($data == false){
				$sqltagfalse = "INSERT INTO tags (id_tag,nom) VALUES ('','".($tag)."')";
				mysql_query($sqltagfalse);
			}
			
			// The query retrieve the id_tag of the tag written in the form
			$sqlnewtag = "Select id_tag FROM tags WHERE nom =('".($tag)."') ORDER BY id_tag DESC LIMIT 0,1";
			$data_idtag = mysql_fetch_array(mysql_query($sqlnewtag));
			$id_tag = $data_idtag["id_tag"];

			// Then it bound it with the id of the written article
			$sqlbound = "INSERT INTO tags_articles (id_tags, id_articles) VALUES ('".$id_tag."','".$id."')";
			mysql_query($sqlbound);

			header('Location:index.php'); //redirection to index.php
			exit();
		} 
	
	//IF the Form isn't filled yet
	}else{
		$titre = '';
		$texte = '';
		$tag='';
		
		//But if there is an article id on the address bar
		if(var_get('id')){ 
			//The query retrieve the data of the article bounded to the id from the GET method
			$id=mysql_real_escape_string(var_get('id'));
			$sql="SELECT * FROM articles WHERE id=".$id;		
			$data=mysql_fetch_array(mysql_query($sql));
			$titre = $data['titre']; //The retrieved data is stocked in $titre & $texte
			$texte = $data['texte'];
			
			//This Query select the name of the tag BEFORE the article (and the tag) is the edited
			$sql = "SELECT t.nom FROM tags_articles ta INNER JOIN tags t ON ta.id_tags = t.id_tag WHERE id_articles =".$id;
			$data = mysql_fetch_array(mysql_query($sql));
			$tag = $data['nom'];
			$ancientag = $tag; //$ancientag will be used ABOVE
	
			$sqltag = "Select count(ta.id_tags) as count_tag FROM tags t INNER JOIN tags_articles ta ON t.id_tag = ta.id_tags WHERE t.nom = '".$tag."'";
			$data = mysql_fetch_array(mysql_query($sqltag));
			$counttag = $data['count_tag'];
		}
			
		$section_label =(var_get('id')) ? 'Modifier' : 'Ajouter'; //Label will be changed is the article is being edited insteaf of being created
		echo "<h3>".$section_label." un article</h3>";
		
		//Security to avoid intruder to create & modify article without being connected
		if($connecte==true){
?>
			<form method=POST action='article.php' enctype='multipart/form-data'>
				<div class="clearfix">
					<label for='titre'>Titre</label>
					<div class='input'>
						<input type='text' name='titre' id='titre' value="<?php echo $titre;?>">	
					</div>
				</div>
	
				<div class="clearfix">
					<label for='tag'>Tag</label>
					<div class='input'>
						<input type='text' name='tag' id='tag' value="<?php echo $tag;?>">	
					</div>
				</div>
				
				<!--Input hidden $counttag & $ancientag used with POST method for being used ABOVE-->
				<!--Beginning-->
				<div class='input'>
					<input type='hidden' name='counttag' value="<?php echo $counttag ;?>">
				</div>
				
				<div class='input'>
					<input type='hidden' name='ancientag' value="<?php echo $ancientag ;?>">
				</div>
				<!--END-->
	
				<div class="clearfix">	
					<label for='texte'>Contenu de l'article</label>
					<div class='input'>
						<textarea name='texte' id='texte'><?php echo $texte;?></textarea>
					</div>		
				</div>
	
				Image : <input type='file' name='image' id='image'>
	
				<div class='form-actions'>
	
					<?php 
					//If the article is being currently edited
					if ($section_label == 'Modifier') {
						echo "<input type='hidden' name='id' value='".$id."'>";
					} ?>	
					<input type='submit' value='<?php echo $section_label;?>' class='btn btn-large btn-primary'>
				</div>
			</form>
			
			<!--Script to verify if both Title & the text area if filled, otherwise the submit won't work and an error will be generated in the console -->
			<script>
				$( "form" ).submit(function( event ) {
					console.log("Vérif contenu Form");
					var titre = $("#titre").val();
					var texte = $("#texte").val();
					if( titre && texte ){
						return true;
					}else {
						console.log("Pas de titre ou de texte");
						return false;
					}
				});  
			</script>
	
	 	

<?php
		}else {
			header('Location:index.php'); //redirection to the index.php
			require_once('includes/footer.php'); 
		}
	}
?>   
