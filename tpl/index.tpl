<html>
	<head></head>	
	<body>
		{if $recherche EQ true}
			<h2>Recherche</h2>
			{if $total_article EQ 0}
				<p>L'article que vous recherchez n'existe pas !</p>
			{elseif $total_article EQ 1}
				<p>Il y a 1 article</p>
			{else}
				<p>Il y a {$total_article} articles</p>
			{/if}
		{else}
		
		<h2>Accueil</h2>
		{/if}
		
		{foreach $articles as $article}
			<h3>{$article.titre}</h3>
			Tags:
			
			{foreach $tags_articles as $tag_article}			
				{if $tag_article.id == $article.id}
					 <span class="badge">{$tag_article.nom}</span> 
				{/if}
			{/foreach}
			
			<br/><br/>
			
			{if file_exists("data/images/{$article.id}.jpg")} 
				<div style="width: 250px;">
					<img src="data/images/{$article.id}.jpg"/>
				</div>
			{/if}
			
			<br/>
			
			{$article.texte}
			<br>Rédigé le {$article.date|date_format:" %e %b %Y"}
			{if $connecte EQ true}
				<form method=GET action='article.php'>
					<input type='hidden' name='id' value='{$article.id}'>
					<br><input type='submit' value='Modifier' class='btn btn-large btn-primary'>
					<a href ='supprimer_article.php?id={$article.id}' class='btn btn-large btn-primary' style='background-color : red;'>Supprimer</a>
			 	</form>
			{/if}
			
			<hr/>
			
		{/foreach}
		
		<br><br>
		
		{if $page gt $nb_pages}
			<div class='alert alert-info'>
				Aucun article ici !
			</div>
		{/if}
		
		<ul id='pagination'>
		
		{if $page>1 && $page le $nb_pages}
			<li class='precedent'> <a href='index.php?p={$page-1}'>Précédent</a> </li> 
		{/if}
		
		{for $p=1 to $nb_pages}
			<li> <a href='index.php?p={$p}'>{$p}</a> </li>
		{/for}
		
		{if $page lt $nb_pages } 
			<li class='suivant'><a href='index.php?p={$page+1}'>Suivant</a> </ul> 
		{/if}
		
	</body>
</html>