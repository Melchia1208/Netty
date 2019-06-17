$ = jQuery = $;

// ACTION QUAND ON CLIQUE SUR LE BOUTON CREER (AFFICHAGE FORMULAIRE + REMISE A ZERO DES CHAMPS)
$("#bouton-creer").click(function(){
    $("#creer").removeClass("d-none").addClass("appear");
    $("#modifier").addClass("d-none");
    $("#base").addClass("d-none");

    $("#lastname, #firstname, #phone, #email").val(null);
    $("#town").val('Paris');
});


// FONCTION QUI ENVOIE LES DONNEES D'UN NOUVEAU CONTACT A LA FONCTION ADD ET QUI CREE UN NOUVEAU CONTACT DANS LA VUE
$("#form-ajouter").submit(function(){

    lastname = $(this).find("input[name=lastname]").val().toUpperCase();
    firstname = $(this).find("input[name=firstname]").val();
    number = $(this).find("input[name=number]").val();
    email = $(this).find("input[name=email]").val();
    town = $(this).find("select[name=town]").val();

    $.ajax({
        url:"/add",
        type: 'POST',
        data: 'lastname='+ lastname + '&firstname='+ firstname + '&number='+ number +'&email='+ email + '&town=' +town,
        dataType: 'html',
        success : function(data){
            $(".bouton-contact").removeClass('last-contact');
            $("#ajax").append('<a href=\"\" id=\"'+data+'\" class=\"list-group-item list-group-item-action bouton-contact last-contact\">'+ lastname + ' ' + firstname +'</a>');
            $(".last-contact").hide().slideDown();
        }
    });
    return false;
});


// FONCTION QUI AFFICHE LES DONNEES D'UN CONTACT EXISTANT
$(document.body).on('click', '.bouton-contact',  function(){
    $("#modifier").addClass("d-none");
    setTimeout(function(){
        $("#modifier").removeClass("d-none").addClass("appear");
    },1);
    $("#creer").addClass("d-none");
    $("#base").addClass("d-none");

    $.ajax({
        url:"/"+$(this).attr('id'),
        type: 'POST',
        data: 'id='+$(this).attr('id'),
        dataType: 'json',
        success : function(data){
            $("#show-id").val(data["id"]);
            $("#show-lastname").val(data["nom"]);
            $("#show-firstname").val(data["prenom"]);
            $("#show-email").val(data["email"]);
            $("#show-phone").val(data["tel"]);
            $("#show-town").val(data["ville"]);
        }
    });
    return false;
});


// FONCTION QUI ENVOIE A LA FONCTION CHANGE LES DONNEES D'UN CONTACT A MODIFIER DANS LA BASE DE DONNEES
$("#form-modifier").submit(function(){

    id = $(this).find("input[name=id]").val();
    lastname = $(this).find("input[name=lastname]").val().toUpperCase();
    firstname = $(this).find("input[name=firstname]").val();
    number = $(this).find("input[name=number]").val();
    email = $(this).find("input[name=email]").val();
    town = $(this).find("select[name=town]").val();

    $.ajax({
        url:"/change/"+id,
        type: 'POST',
        data: 'lastname='+ lastname + '&firstname='+ firstname + '&number='+ number +'&email='+ email + '&town=' + town + '&id=' + id,
        dataType: 'html',
        success : function(){
            alert('Le contact a bien été modifié')
        }
    });
    return false;
});
