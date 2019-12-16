/*  fonctions js personnalisées utiles pour le projet */
    $(document).ready(function () {
        // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
        var $container = $('div#purchase_linePurchase');
        // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
        var index = $container.find(':input').length;
        
        // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
        $('#add_linePurchase').click(function (e) {
            addLinePurchase($container);
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
        // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle line purchase par exemple).
        if (index == 0) {
            addLinePurchase($container);
        } else {
            // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
            $container.children('div').each(function () {
                addDeleteLink($(this));
            });
        }
        function addLinePurchase($container) {
            // Dans le contenu de l'attribut « data-prototype », on remplace :
            // - le texte "__name__label__" qu'il contient par le label du champ
            // - le texte "__name__" qu'il contient par le numéro du champ
            var template = $('div#template_tmp').html()
                .replace(/__name__label__/g, 'مشتريات عدد:' + (index + 1))
                .replace(/__name__/g, index)
            ;
            // On crée un objet jquery qui contient ce template
            var $prototype = $(template);

            // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
            addDeleteLink($prototype);
            // On ajoute le prototype modifié à la fin de la balise <div>
            $container.append($prototype);

            // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
            index++;
        }
        /*===============*/
        var $container1 = $('div#exitt_lineExitt');
        var index1 = $container1.find(':input').length;

        $('#add_lineExitt').click(function (e) {
            addLineExitt($container1);
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
        if (index1 == 0) {
            addLineExitt($container1);
        } else {
            $container1.children('div').each(function () {
                addDeleteLink($(this));
            });
        }
        function addLineExitt($container1) {

            var template = $('div#template_tmp').html()
                .replace(/__name__label__/g, 'خروج عدد:' + (index1 + 1))
                .replace(/__name__/g, index1)
            ;
            var $prototype = $(template);

            addDeleteLink($prototype);
            $container1.append($prototype);

            index1++;
        }
        /*------------*/
        var $container2 = $('div#requestSupplied_lineRequestSupplied');

        var index2 = $container2.find(':input').length;

        $('#add_lineRequestSupplied').click(function (e) {
            addLineRequestSupplied($container2);
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
        if (index2 == 0) {
            addLineRequestSupplied($container2);
        } else {
            $container2.children('div').each(function () {
                addDeleteLink($(this));
            });
        }
        function addLineRequestSupplied($container2) {

            var template = $('div#template_tmp').html()
                .replace(/__name__label__/g, 'مادة عدد:' + (index2 + 1))
                .replace(/__name__/g, index2)
            ;
            var $prototype = $(template);

            addDeleteLink($prototype);
            $container2.append($prototype);

            index2++;
        }
        /* ---------------------- */
        // La fonction qui ajoute un lien de suppression d'une catégorie
        function addDeleteLink($prototype) {
            // Création du lien
            var $deleteLink = $prototype.find('#btn-delete');
            // var $deleteLink = $('<a href="#" class="btn btn-danger">حذف</a>');
            // Ajout du lien
            //$prototype.append($deleteLink);
            // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
            $deleteLink.click(function (e) {
                $prototype.remove();

                e.preventDefault(); // évite qu'un # apparaisse dans l'URL
                return false;
            });
        }
    });
/*     ===========================test de reférence d'une article=========================== */
/* $("#register").click(function() {
    var reference_stock = $('#article_reference_stock').val();
    console.log('La valeur récupéreé est:'+reference_stock)
    $('#article_reference_stock').removeClass("border_error");
    console.log('Ref : '+reference_stock);
    var response = $.ajax({
        type: "GET",
        url: "{{ url('reference_check_validity') }}",
        data: {reference_stock: reference_stock},//(parametre: valeur)
        async: false
    }).responseText;
    console.log(response);
    if(response == 'exist'){
        $('#article_reference_stock').addClass("border_error");
        $('#reference_result').addClass("error_style");
        $("#reference_result").text("خطأ:هذا المرجع موجود");
        return false;
    }else{
        return true;
    }
});
 */
/*-------------------*/
$("#exitt_save").click(function() {
    var quantity = $('#exitt_lineExitt_0quantity').val();
    console.log('La valeur récupéreé est:'+quantity)
    $('#exitt_lineExitt_0quantity').removeClass("border_error");
    console.log('Ref : '+quantity);
    var response = $.ajax({
        type: "GET",
        url: "{{ url('quantity_check_disponibility') }}",
        data: {quantity: quantity},//(parametre: valeur)
        async: false
    }).responseText;

    console.log(response);

    if(response == 'indisponible'){
        $('#exitt_lineExitt_0quantity').addClass("border_error");
        $('#quantity_result').addClass("error_style");
        $("#quantity_result").text("لا يمكن:هذه الكمية غير متوفرة بالمخزن");
        return false;
    }else{
        return true;
    }

});




/*

 $(function() {
 $('.datepicker').daterangepicker({
 locale: {
 format: 'MM/DD/YYYY'
 }
 });
 });
 */
/*$(function() {
    $('input[class="datepicker"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true
        },
        function(start, end, label) {
            var years = moment().diff(start, 'years');
            alert("You are " + years + " years old.");
        });
});*/
/*
$(function() {
    $('#single_cal1').daterangepicker({
        singleDatePicker: true,
        singleClasses: "picker_1"
    }, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
    });
});*/
