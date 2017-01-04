<!-- HEADER -->
<div class="header" id="essai-gratuit">
    <h1 class="title">
        Découvrez<br/>
        <span class="size1">projectsquare</span><br/>
        <span class="size2">la plateforme de gestion</span><br/>
        développée pour optimiser<br/>
        vos projets web
    </h1>

    <h2 class="subtitle">
        <span class="free-trial">1 mois gratuit</span>Nombre de projets, de collaborateurs et de clients <strong>ILLIMITÉ</strong>
    </h2>

    <div class="try">
        <input type="text" placeholder="E-MAIL" name="email" />
        <input type="password" placeholder="MOT DE PASSE" name="password" />
        <input type="text" placeholder="URL" name="url" style="margin-right:6px"/> <span class="url-suffix">.projectsquare.io</span>
        <input type="submit" class="button" value="COMMENCER" />
        <span class="loading" style="display: none">Chargement ...</span>
        {{ csrf_field() }}
    </div>

    <div class="alert alert-danger error" style="display: none"></div>
</div>
<!-- HEADER -->

