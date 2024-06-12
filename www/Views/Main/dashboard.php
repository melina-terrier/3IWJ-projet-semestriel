<h1>Tableau de bord</h1>

<section>

	<article>
		<h3>Pages</h3>
		<p><?php echo $elementsCount['pages']; ?></p>
	</article>

	<article>
		<h3>Projets</h3>
		<p><?php echo $elementsCount['projects']; ?></p>
	</article>

	<article>
		<h3>Tags</h3>
		<p><?php echo $elementsCount['tags']; ?></p>
	</article>
		
	<article>
		<h3>Médias</h3>
		<p><?php echo $elementsCount['medias']; ?></p>
	</article>

	<article>
		<h3>Utilisateurs</h3>
		<p><?php echo $elementsCount['users']; ?></p>
	</article>

	<article>
		<h3>Commentaires</h3>
		<p><?php echo $elementsCount['comments']; ?></p>
	</article>

</section>

<section>
	<h2>Commentaires en attentes de validation</h2>
	<?php 
		foreach ($comments as $comment) {
			if($comment['status'] == 0){
				echo '<article>
					<p>'.$comment["name"].'</p>
					<p>'.$comment["comment"].'<p>
				</article>';
			}
		}
	?>
</section>