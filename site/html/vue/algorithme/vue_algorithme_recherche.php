<!--
vue_algorithme_recherche.php
Date de création : 16/01/20121
Fonction : vue pour effectuer une recherche
Sources utilisées :
https://mdbootstrap.com/docs/standard/forms/search/
https://www.w3schools.com/howto/howto_css_search_button.asp
__________________________________________
 -->
<form class='form' method='POST' action="index.php?action=vue_algorithme_recherche">
<div class="input-group">
    <input type="search" name ="chercher" class="form-control rounded" placeholder="Séparés les termes par une virgule" aria-label="Search"
           aria-describedby="search-addon" />
    <button type="submit" class="btn btn-outline-primary">Chercher un algorithme</button>
</div>
</form>