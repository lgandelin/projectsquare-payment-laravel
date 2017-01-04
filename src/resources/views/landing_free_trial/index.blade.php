<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ trans('projectsquare-payment::pages.seo_title_landing_free_trial') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
</head>
<body>

<div class="landing-free-trial-template container">

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

    <!-- SIMPLIFIEZ-VOUS -->
    <div class="simplifiez-vous row" id="simplifiez">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="title">Simplifiez-vous…</div>
            <div class="atouts">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 atout">
                    <h2 class="sub_title">le travail <br />en équipe</h2>
                    <div class="img nuage"></div>
                    <p>Gérez vos projets de manière transversale, attribuez les rôles, partagez vos plannings...</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 atout">
                    <h2 class="sub_title">la gestion <br />de vos sites</h2>
                    <div class="img gestion"></div>
                    <p>Administrez tous vos sites, visualisez les statistiquess Google analytics, surveillez la disponibilité de vos sites...</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 atout">
                    <h2 class="sub_title">votre relation <br /> client</h2>
                    <div class="img oiseau"></div>
                    <p>Facilitez les échanges avec vos clients avec la messagerie interne, gestion de tickets, dépôt de fichiers...</p>
                </div>
            </div>
        </div>

        <hr>
    </div>
    <!-- SIMPLIFIEZ-VOUS -->

    <!-- FONCTIONNALITES -->
    <div class="blocs bloc_fonctionalites">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Et optimisez la rentabilité de vos projets web grâce aux fonctionnalités suivantes...</h2>
            </div>
        </div>
        <div class="row">
            <div class="bloc_fonctionnalite bloc_fonctionnalite1 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="active">
                    <span class="img img-relation-client"></span>
                    <h3 class="title_maj"> relation <br />client<br /></h3>
                </div>
            </div>
            <div class="bloc_fonctionnalite bloc_fonctionnalite2 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="active">
                    <span class="img img-organisation"></span>
                    <h3 class="title_maj"> organisation <br />productivité<br /></h3>
                </div>
            </div>

            <div class="bloc_fonctionnalite bloc_fonctionnalite3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="active">
                    <span class="img img-maintenance"></span>
                    <h3 class="title_maj"> maintenance</h3>
                </div>
            </div>
            <div class="bloc_fonctionnalite bloc_fonctionnalite4 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="active">
                    <span class="img img-connexion"></span>
                    <h3 class="title_maj"> connexion <br /> outils externes</h3>
                </div>
            </div>
        </div>

        <div class="row features-description">

            <!-- RELATION CLIENT -->
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 feature-content" id="bloc_fonctionnalite1-content">
                <ul class="features">
                    <li data-feature="1" class="active">
                        <i class="icon-feature-1"></i>
                        <span class="feature">Messagerie</span>
                        <p class="description">
                            Que ce soit pour vous ou vos clients, gardez tous les échanges relatifs au projet sur Projectsquare.
                        </p>
                    </li>

                    <li data-feature="2">
                        <i class="icon-feature-2"></i>
                        <span class="feature">Calendrier projet</span>
                        <p class="description">
                            Définissez les phases de vos projets, les étapes de livrables et validations et partagez-le avec vos collaborateurs et vos clients.
                        </p>
                    </li>

                    <li data-feature="3">
                        <i class="icon-feature-3"></i>
                        <span class="feature">Dépôt de fichiers</span>
                        <p class="description">
                            Partagez et mettez à disposition de vos clients tous les éléments relatifs à leur projet.
                        </p>
                    </li>
                </ul>
            </div>
            <!-- RELATION CLIENT -->

            <!-- ORGANISATION -->
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 feature-content" id="bloc_fonctionnalite2-content" style="display: none">
                <ul class="features">
                    <li data-feature="4" class="active">
                        <i class="icon-feature-4"></i>
                        <span class="feature">Planning</span>
                        <p class="description">
                            Le planning d’équipe permet au chef de projet d’inviter des collaborateurs à un projet et de leur attribuer des tâches.
                        </p>
                    </li>

                    <li data-feature="5">
                        <i class="icon-feature-2"></i>
                        <span class="feature">Calendrier projet</span>
                        <p class="description">
                            Définissez les phases de vos projets, les étapes de livrables et validations et partagez-le avec vos collaborateurs et vos clients.
                        </p>
                    </li>

                    <li data-feature="6">
                        <i class="icon-feature-6"></i>
                        <span class="feature">Rentablité</span>
                        <p class="description">
                            Partagez et mettez à disposition de vos clients tous les éléments relatifs à leur projet.
                        </p>
                    </li>
                </ul>
            </div>
            <!-- ORGANISATION -->

            <!-- MAINTENANCE -->
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 feature-content" id="bloc_fonctionnalite3-content" style="display: none">
                <ul class="features">
                    <li data-feature="7" class="active">
                        <i class="icon-feature-7"></i>
                        <span class="feature">Analyse du trafic</span>
                        <p class="description">
                            Customisez les informations SEO que vous souhaitez afficher et proposez les à vos clients.
                        </p>
                    </li>

                    <li data-feature="8">
                        <i class="icon-feature-8"></i>
                        <span class="feature">Tickets de maintenance</span>
                        <p class="description">
                            Créer des tickets, intégrés au planning, classés par état et partagés avec vos clients.
                        </p>
                    </li>

                    <li data-feature="9">
                        <i class="icon-feature-9"></i>
                        <span class="feature">Monitoring serveur</span>
                        <p class="description">
                            Suivez les temps de réponse et les erreurs serveur de vos sites, et recevez une alerte dès qu’un de ces voyant passe au rouge.
                        </p>
                    </li>
                </ul>
            </div>
            <!-- MAINTENANCE -->

            <!-- CONNEXION OUTILS EXTERNES -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 feature-content" id="bloc_fonctionnalite4-content" style="display: none">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="feature-text">
                        <img src="{{ asset('img/landing-free-trial/features/logo-slack.png') }}" width="148" height="134" />
                        <div class="description">
                            <span class="feature">Slack</span>
                            Recevez directement dans vos channels Slack les notifications de Projectsquare.
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="feature-text">
                        <img src="{{ asset('img/landing-free-trial/features/logo-google-analytics.png') }}" width="119" height="117" />
                        <div class="description">
                            <span class="feature">Google Analytics</span>
                            Affichez les statistiques Google Analytics directement sur Projecsquare.
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3">
                    <div class="feature-text">
                        <img src="{{ asset('img/landing-free-trial/features/logo-excel.png') }}" width="137" height="131" />
                        <div class="description">
                            <span class="feature">Excel</span>
                            Exportez directement toutes les infos de vos projets sous format Excel.
                        </div>
                    </div>
                </div>
            </div>
            <!-- CONNEXION OUTILS EXTERNES -->

            <!-- IMAGES -->
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div id="feature-1" class="feature-image" style="display: block"><img src="{{ asset('img/landing-free-trial/features/feature-1.jpg') }}" /></div>
                <div id="feature-2" class="feature-image" style="display: none"><img src="{{ asset('img/landing-free-trial/features/feature-2.jpg') }}" /></div>
                <div id="feature-3" class="feature-image" style="display: none"><img src="{{ asset('img/landing-free-trial/features/feature-3.jpg') }}" /></div>
                <div id="feature-4" class="feature-image" style="display: none"><img src="{{ asset('img/landing-free-trial/features/feature-4.jpg') }}" /></div>
                <div id="feature-5" class="feature-image" style="display: none"><img src="{{ asset('img/landing-free-trial/features/feature-2.jpg') }}" /></div>
                <div id="feature-6" class="feature-image" style="display: none"><img src="{{ asset('img/landing-free-trial/features/feature-6.jpg') }}" /></div>
                <div id="feature-7" class="feature-image" style="display: none"><img src="{{ asset('img/landing-free-trial/features/feature-7.jpg') }}" /></div>
                <div id="feature-8" class="feature-image" style="display: none"><img src="{{ asset('img/landing-free-trial/features/feature-8.jpg') }}" /></div>
                <div id="feature-9" class="feature-image" style="display: none"><img src="{{ asset('img/landing-free-trial/features/feature-9.jpg') }}" /></div>
            </div>
            <!-- IMAGES -->
        </div>

    </div>
    <!-- FONCTIONNALITES -->

    <!-- FOOTER -->
    <div class="footer">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="blue-wrapper">
                    <a class="start-free-trial button" href="#essai-gratuit">Démarrer mon essai gratuit</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="green-wrapper">
                    <span class="copyright">&copy; 2016</span>
                </div>
            </div>
        </div>
    </div>
    <!-- FOOTER -->

    <script>var route_check_slug = "{{ route('signup_check_slug') }}";</script>
    <script>var route_free_trial_handler = "{{ route('landing_free_trial_handler') }}";</script>
    <script src="{{ asset('js/signup.js') }}"></script>
    <script>

        //Free trial validation
        $('.landing-free-trial-template .try input[type="submit"]').click(function() {
            $('.try .loading').show();
            $('.landing-free-trial-template .error').hide();
            var submit_button = $(this);
            submit_button.hide();
            $.ajax({
                type: "POST",
                url: route_free_trial_handler,
                data: {
                    _token: $('input[name="_token"]').val(),
                    email: $('.landing-free-trial-template .try input[name="email"]').val(),
                    password: $('.landing-free-trial-template .try input[name="password"]').val(),
                    url: $('.landing-free-trial-template .try input[name="url"]').val()
                },
                success: function (data) {
                    if (data.success == false) {
                        $('.landing-free-trial-template .try .loading').hide();
                        submit_button.show();
                        $('.landing-free-trial-template .error').show().text(data.error);
                    } else {
                        window.location.href = data.redirection_url;
                    }
                }
            });
        });

        //Anchor
        $('a[href^="#"]').click(function(){
            var id = $(this).attr("href");
            var offset = $(id).offset().top;
            $('html, body').animate({scrollTop: offset}, 800);

            return false;
        });

        //Features
        $('.bloc_fonctionnalite1').click(function() {
            $('.feature-content').hide();
            $('#bloc_fonctionnalite1-content').show();
            displayFeature(1);
        });

        $('.bloc_fonctionnalite2').click(function() {
            $('.feature-content').hide();
            $('#bloc_fonctionnalite2-content').show();
            displayFeature(4);
        });

        $('.bloc_fonctionnalite3').click(function() {
            $('.feature-content').hide();
            $('#bloc_fonctionnalite3-content').show();
            displayFeature(7);
        });

        $('.bloc_fonctionnalite4').click(function() {
            $('.feature-content').hide();
            $('#bloc_fonctionnalite4-content').show();
            $('.feature-image').hide();
        });

        $('.features li').click(function(e) {
            e.preventDefault();
            displayFeature($(this).data('feature'));
        });

        function displayFeature(tab) {
            $('.features li').removeClass('active');
            $('.feature-image').hide();
            $('#feature-' + tab).show();
            $('.features li[data-feature="' + tab + '"]').addClass('active');
        }
    </script>

    @include('projectsquare-payment::includes.ga_tracker')
</body>
</html>