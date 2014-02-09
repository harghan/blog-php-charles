<?php
	require_once('includes/header.php'); 
	
	//This condition permit to avoid any intruders to delete any article by injection on the adress bar
	if($connecte==true){ 
		// We use GET to receive the ID from the adress bar
		$id=mysql_real_escape_string(var_get('id'));
		 
		// This Sql query permit to count the total of the id of the tags used by the article which is going to be deleted
		$sqlcounttag = "Select count(id_tags) as totaltag FROM tags_articles WHERE id_tags = (Select DISTINCT id_tags FROM tags_articles WHERE id_articles ='".$id."'LIMIT 0,1)";
		$data = mysql_fetch_array(mysql_query($sqlcounttag));
		$counttag = $data['totaltag'];
		
		// and if this query return "1" it means that the article which is going to be deleted is the only one who is using this tag
		// it means that the tag won't be used by any articles, so it don't belong to stay in the database and have to be deleted
		if ($counttag == "1"){ 
			$sqlsupptag = "DELETE t.* FROM tags t INNER JOIN tags_articles ta ON t.id_tag = ta.id_tags WHERE ta.id_articles = ".$id;
			mysql_query($sqlsupptag);
			// The non-attributed tag is deleted
		}
		
		//The selected article will be deleted with this query
		$sql="DELETE FROM articles WHERE id=".$id.";";
		mysql_query($sql);
		//The link between the article and the tag will be deleted with this query
		$sql="DELETE FROM tags_articles WHERE id_articles=".$id.";";
		mysql_query($sql);
		
		//Since the article is deleted, we don't need the image anymore, so we delete it
		$path = dirname(__FILE__)."/data/images/$id.jpg";
		unlink($path);
		
		//A notification appear to confirm the deleted article; /!\ it will appear on the index.php /!\
		$_SESSION['article']='supprimer';
	}
	
	//We go back to the index.php
	header('Location:index.php');
	exit();
?>