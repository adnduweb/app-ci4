<script>
    tarteaucitron.init({
        "privacyUrl": "<?= (service('settings')->get('Pages.consent', 'urlConsent_'.service('request')->getLocale())) ?  service('settings')->get('Pages.consent', 'urlConsent_'.service('request')->getLocale()) : "" ; ?>", /* URL de la page de la politique de vie privée */

        "hashtag": "#tarteaucitron", /* Ouvrir le panneau contenant ce hashtag */
        "cookieName": "tarteaucitron", /* Nom du Cookie */

        "orientation": "middle", /* Position de la bannière (top - bottom) */
        "showAlertSmall": false, /* Voir la bannière réduite en bas à droite */
        "cookieslist": true, /* Voir la liste des cookies */

        "adblocker": false, /* Voir une alerte si un bloqueur de publicités est détecté */
        "AcceptAllCta": true, /* Voir le bouton accepter tout (quand highPrivacy est à true) */
        "highPrivacy": true, /* Désactiver le consentement automatique */
        "handleBrowserDNTRequest": false, /* Si la protection du suivi du navigateur est activée, tout interdire */

        "removeCredit": true, /* Retirer le lien vers tarteaucitron.js */
        "moreInfoLink": true, /* Afficher le lien "voir plus d'infos" */
        "useExternalCss": false, /* Si false, tarteaucitron.css sera chargé */
        "showIcon": false,

        //"cookieDomain": ".my-multisite-domaine.fr", /* Cookie multisite */

        "readmoreLink": "/cookiespolicy" /* Lien vers la page "Lire plus" */
    });

    if ( typeof(tarteaucitron.job) == "undefined" ) {
        tarteaucitron.job = [];
    }

    /* Fonction qui permet de relancer le chargement d'un service */
    /* exemple de service : "youtube" */
    function rgpd_sa_refresh_service(service) {
    	if ( typeof(tarteaucitron.state) !== 'undefined' && typeof(tarteaucitron.services[service]) !== 'undefined' ){
	    	if(tarteaucitron.state[service]) {
	    		tarteaucitron.services[service].js();
			} else {
				tarteaucitron.services[service].fallback();
			}
    	}  
    };

    //Services
    <?php if(!empty(service('settings')->get('App.core', 'tagManager'))){ ?>
        tarteaucitron.user.gtagUa = 'UA-XXXXXXXX-X';
        tarteaucitron.user.gtagMore = function () { /* add here your optionnal gtag() */ };
        (tarteaucitron.job = tarteaucitron.job || []).push('gtag');
    <?php } ?>

     <?php if(!empty(service('settings')->get('App.core', 'googleAnalitycs_'.service('request')->getLocale()))){ ?>
        (tarteaucitron.job = tarteaucitron.job || []).push('analitycs');

        tarteaucitron.services.analytics = {
            "key": "analytics",
            "type": "analytic",
            "name": "analytics",
            "uri": "",
            "needConsent": true,
            "cookies": [],
            "js": function () {
                "use strict";
                
                    tarteaucitron_analytics();

            },
            "fallback": function () { // Si désactivé
            }
            
        };
        
        function  tarteaucitron_analytics() { // Si activé
        }
    <?php } ?>

    <?php if(!empty(service('settings')->get('App.core', 'googleMaps'))){ ?>
        (tarteaucitron.job = tarteaucitron.job || []).push('googlemaps');

        tarteaucitron.services.googlemaps = {
            "key": "googlemaps",
            "type": "api",
            "name": "google Maps",
            "uri": "https://adssettings.google.com/anonymous?hl=fr&sig=ACi0TCjQ9hjLj9PElus39KNL8ixwGLaUzNDBeiXMdXYieOtZ66ujnVEBJ2-7mgp4N9g-X6OgJb_3ns-yVv3fJ31MXyJk5zuCOHiyHyo3v3opePfQ4HBBHl8",
            "needConsent": true,
            "cookies": [],
            "js": function () {
                "use strict";
                    tarteaucitron_googlemaps();
            },
            "fallback": function () { // Si désactivé
                $('.googlemaps').addClass('rgpd_sa_disabled');
                $(".googlemaps").click(function(event){ 
                        if( $(this).hasClass("rgpd_sa_disabled") ) {
                            event.preventDefault();
                            event.stopPropagation();
                            $("#RGPD_SA_MODAL #RGPD_SA_MODAL_COOKIE_NAME").html("google Maps");
                            $("#RGPD_SA_MODAL").css("display", "block"); // Affichage de la modale
                            $("#RGPD_SA_MODAL_BTN_ENABLE").data("tarteaucitronKey", "googlemaps"); // Valorisation du data-tarteaucitronKey
                        }
                });

            }
            
        };
				        
        function  tarteaucitron_googlemaps() { // Si activé
            $('.googlemaps').removeClass('rgpd_sa_disabled');
            
            var script_callback = "";
            var script = document.createElement( "script" );
            script.setAttribute("type", "text/javascript");
            script.setAttribute("src" , 'https://maps.google.com/maps/api/js?key=<?= service('settings')->get('App.core', 'googleMaps'); ?>&libraries=places&callback=initMap');
            script.setAttribute('async','');
            script.setAttribute('defer','');
            $("script#rgpd_script_maps").replaceWith(script); 
        }
                        
    <?php } ?>

    <?php if(service('settings')->get('App.rgpd', 'rgpdYoutube') == 1){ ?>
        (tarteaucitron.job = tarteaucitron.job || []).push('youtube');

        tarteaucitron.services.youtube = {
            "key": "youtube",
            "type": "video",
            "name": "Youtube",
            "uri": "",
            "needConsent": true,
            "cookies": [],
            "js": function () {
                "use strict";
                    tarteaucitron_youtube();
            },
            "fallback": function () { // Si désactivé
            }
            
        };
        
        function  tarteaucitron_youtube() { // Si activé
        }
    <?php } ?>

    <?php if(service('settings')->get('App.rgpd', 'rgpdDaylimotion') == 1){ ?>
        (tarteaucitron.job = tarteaucitron.job || []).push('daylimotion');

        tarteaucitron.services.daylimotion = {
            "key": "daylimotion",
            "type": "video",
            "name": "Daylimotion",
            "uri": "",
            "needConsent": true,
            "cookies": [],
            "js": function () {
                "use strict";
                    tarteaucitron_daylimotion();
            },
            "fallback": function () { // Si désactivé
            }
            
        };
        
        function  tarteaucitron_daylimotion() { // Si activé
        }
    <?php } ?>

    <?php if(service('settings')->get('App.rgpd', 'rgpdVimeo') == 1){ ?>
        (tarteaucitron.job = tarteaucitron.job || []).push('vimaeo');

        tarteaucitron.services.vimaeo = {
            "key": "vimaeo",
            "type": "video",
            "name": "Vimaeo",
            "uri": "",
            "needConsent": true,
            "cookies": [],
            "js": function () {
                "use strict";
                    tarteaucitron_vimaeo();
            },
            "fallback": function () { // Si désactivé
            }
            
        };
        
        function  tarteaucitron_vimaeo() { // Si activé
        }
    <?php } ?>


    <?php if(service('settings')->get('App.rgpd', 'rgpdFacebook') == 1){ ?>
        (tarteaucitron.job = tarteaucitron.job || []).push('facebook');

        tarteaucitron.services.facebook = {
            "key": "facebook",
            "type": "video",
            "name": "Facebook",
            "uri": "",
            "needConsent": true,
            "cookies": [],
            "js": function () {
                "use strict";
                    tarteaucitron_facebook();
            },
            "fallback": function () { // Si désactivé
                $('.rgpd_sa_facebook').addClass('rgpd_sa_disabled');
            }
            
        };
        
        function  tarteaucitron_facebook() { // Si activé
            $('.rgpd_sa_facebook').removeClass('rgpd_sa_disabled');
        }
    <?php } ?>



   
</script>