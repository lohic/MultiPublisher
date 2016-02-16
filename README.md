# MultiPublisher
Projet MultiPublisher


cf https://getcomposer.org/doc/01-basic-usage.md

```bash
php composer.phar install
```



## Synthèse

####Méthode de publication d'un article :   
> note : publier les diff étape et générer l'epub en dernier lieux à partir de la publication parente.

Réaliser une première publication > elle représente le livre et son résumé (dans les métadonnés) ;   
Afin de réaliser les différents chapitres, il faut réaliser d'autres publications mais les lier à la première publication (parente). L'ordre des diff enfants peut-être choisi dans la section ordre.

####Utilisation du plugin :  


**Les shortcodes :**

_référence croisée_
`[xref txt="le mot" href="ancre" id="57"]`
permet de générer une référence croisée
`txt : le mot sur lequel est placé la référence`
`href : id vers lequel doit pointer l'ancre`
`id : POST_ID de la publication vers laquelle pointe l'ancre` 

_note de bas de page_
`[note txt="le mot" def="la définition"]`
permet de générer une note de bas de page
`txt : le mot sur lequel est placé la note`
`def : note placée sur le mot`

_galerie_
`[mp_gallery ids="2,3,4" type="g32"]`
permet de générer une galerie
récupère le fichier `themefiles/carnet-du-frac/galleries.json`
`ids : id des images de la galerie`
`type : type de la gallerie (g1,g21,g22,g31,g32,g33,g34,g4)`

_menu format_
menu contextuel permettant la structuration du contenu


####Structure des dossiers
```
+---../../mp-cache/ (dossier cache des epub)
+---inc/
|   ----mp.class.php (classe php du plugin)
|   ----mp.structure.php (déclaration des customs posts)  
|   +---views (contient les différents fichier de structure à afficher pour le backoffice + fichiers ajax)   
|   +---tinymce_js (contient les plugins js pour tinyMCE)  
----mp.function.php : création de fonctions public pouvant être réutilisées.  
+---themeFiles (gabarit des epub)
|   +carnet-du-frac (dossier du thème par défaut)  
|   |   ----galleries.json (contient la description des galeries)
+---vendor (dossier composer) :
|   +---fortawesome (pictogrammes)  
|   +---grant (génération d'epub)  
```

____

####note 15 fev 2016

dans le fichier **inc/mp.class** :  
* ligne 193 > fonction loadLibraries (charge l'ensemble des lib necessaires au fonctionnement du plugin)
    * ligne 234 > création et definition des shortcodes (shortcode gallery)
           add_shortcode( 'mp_gallery', array( $this, 'mp_gallery_shortcode_function') );
  * ligne 330 > function shortcode de la galerie, génére la galerie dans le front
  * ligne 493 > section ajax
              $plugin_array['mp_gallery']       = plugins_url( '/tinymce_js/mp_gallery_plugin.js', __FILE__ )
  > tinymce est un plugin permettant l'ajout et la modification de buttons dans le _visual Editor Toolbar_.   


dans le fichier **inc/tinymce_js/mp_gallery_plugin.js** :

* ligne 151 > **do_spot** : cette fonction a pour but de reconnaître le type de galerie sélectionnée de proposer le bon format html, ainsi que d'insérer une function ajax reliant les images(+metadonnées) à leurs emplacements dans la galerie.
___

### fonctionnement de do_spot
