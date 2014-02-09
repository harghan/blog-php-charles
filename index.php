<?php
 
	include('includes/header.php');
	require ('libs/Smarty.class.php');
	
	//We use smarty
	$smarty = new Smarty();
	$smarty->setTemplateDir('tpl');	// it seek the tpl directory
	
	$app=2;	 //Number of articles per pages															
	$page=(var_get('p'))?var_get('p'):1; //Retrieve the current page
	$debut= (($page -1)*$app); //We take the first article
	$total= mysql_query("SELECT count(*) AS total FROM articles"); //counting the number of articles
	$total = mysql_fetch_array($total); //send the query
	$total = $total['total']; //stocking the query in $total
	$nb_pages= (($total>0)?ceil($total/$app):1); //counting the number of pages it have to show
	
	$recherche=false; //if the user have to use the research bar, it will become true
	
	if(var_get('r')){ //if the user use the research bar
		$recherche=true;
		$rech=mysql_real_escape_string($_GET['r']); 
		$result=mysql_query("SELECT * FROM articles WHERE titre LIKE '%".$rech."%' ORDER BY date DESC LIMIT $debut,$app"); //we get his research
		$nbarticle=mysql_query("SELECT count(*) AS total FROM articles WHERE titre LIKE '%".$rech."%';"); //inserting it into a query and return the number of rows the Database return
		$data=mysql_fetch_array($nbarticle,MYSQL_ASSOC);
		$total=htmlspecialchars_decode($data['total']);
		$smarty->assign('total_article', $total); //assigning it to smarty
	}else {
		$result=mysql_query("SELECT * FROM articles ORDER BY date DESC LIMIT $debut,$app"); //Else we return every articles
	}
	
	$smarty->assign('recherche', $recherche); //Assigning the research to smarty
	$articles = array();
	$i=0;
	
	//This loop will display the articles in connection (relation) wit the research
	while ($data=mysql_fetch_array($result,MYSQL_ASSOC)){ 
		$texte=htmlspecialchars_decode($data['texte']);
		$texte=str_replace("\n","<br>",$texte);
		$titre=htmlspecialchars_decode($data['titre']);
		$titre=str_replace("\n","<br>",$titre);
		$articles[$i]['date']=date('d/m/Y',$data['date']);
		$articles[$i]=$data;		
		$i++;
		file_exists("Blog Charles Jquery 2/data/images");
	}
	
	$tags_articles = array();
	$i=0;
	$result = mysql_query("SELECT articles.id, tags.nom 
						   FROM articles
						   INNER JOIN tags_articles
					       ON tags_articles.id_articles = articles.id
						   INNER JOIN tags
						   ON tags_articles.id_tags = tags.id_tag");  //This query retrieve the tags joined to the articles
	
	//And stock them to display them into the smarty template
	while ($data=mysql_fetch_array($result,MYSQL_ASSOC)){ 
		$tags_articles[$i]=$data;		
		$i++;
	}
	
	mysql_free_result($result); 
	
	$smarty->assign('page', $page);
	$smarty->assign('nb_pages', $nb_pages);
	$smarty->assign('connecte', $connecte);
	$smarty->assign('articles', $articles);
	$smarty->assign('tags_articles', $tags_articles);
	$smarty->display('index.tpl'); // It will display the stocked values in the smarty template
	
    include ('includes/footer.php');
	
?>   