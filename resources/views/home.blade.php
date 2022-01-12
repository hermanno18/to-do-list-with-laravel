<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Laravel</title>

        <!-- Fonts -->
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
        <!-- Styles -->
        
        <!-- JQuery -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
    </head>
    <body class="d-flex justify-content-center align-items-center">
        <div class=" bg-dark p-2 text-white col-10 col-md-6 mt-3">
            @if (Route::has('login'))
            <div class="hidden fixed d-flex justify-content-end">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-primary">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Connexion</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-primary">Inscription</a>
                    @endif
                @endauth
            </div>
        @endif  

        @auth
            <nav class="p-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class=" d-flex justify-content-center p-1 text-primary" style=""><a href=""><i class="fas fa-list-alt h1"></i></a></div>
                    <span class="h3 text-white mx-2"> My To-do-List</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addTaskModal"> <i class="fas fa-plus"></i></span>
                    <a class="btn btn-sm btn-primary" id='saver' > <i class="fas fa-save"></i> &nbsp; savegarder la journée</a>
                </div>
            </nav>
            <div class="mt-2 d-flex justify-content-between ">
                <a class="nav-menu bg-white text-dark p-2 " onclick="findForToday(), hideSearchForm()">Aujourd'hui</a>
                <a class="nav-menu p-2" onclick=" displaysTasks(mode='in_process'), hideSearchForm()">En cour</a>
                <a class="nav-menu p-2" onclick=" displaysTasks(mode='ended'), hideSearchForm()">Terminées</a>
                <a class="nav-menu p-2" onclick="$('#listContainer').html(''), openSearchForm()">Historique</a>
            </div>
            <div class="bg-white">
                <div class="d-none " id="SearchForm">
                    <form action="javascript:void(0)" class="d-flex align-items-center justify-content-center p-1 text-sm ">
                        <label for="" class="text-dark col-4">Selectionnez une date</label>
                        <input type="date" name="" id="hystory_date" class="col-6 form-control">
                        <button class="btn btn-sm btn-info col-2 " onclick="findHistory()">trier</button>
                    </form>
                </div>
                <form action="javascipt:void(0)">
                    <div class=" py-1 px-1 text-dark" id="listContainer">
                    </div>
                </form>
            </div>
        @else
            <div class="d-flex justify-content-center">
                <div class="h3 text-white text-center col-7 mt-5 mb-5">Bienveneu sur l'apli, connectez-vous pour acceder au contenu</div>
            </div>
        @endauth
        </div>

        
        <!-- Modal pour le formulaire d'ajout de taches  -->
        <div class="modal fade text-dark rounded"   id="addTaskModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addTaskModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
                <div class="modal-content rounded">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter une tache </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                  </div>
                <div class="modal-body bg-success-50 ">
                    <div class="d-flex justify-content-between align-items-center text-dark ">
                    <div class="">
                        <form action="javascript:void(0)">
                            <div class="text-danger" id="form_display_error"></div>
                            <div class="text-success" id="form_display_success"></div>
                            <div class=" p-3 bg-white border border-primary">
                                <input class="form-control mb-1 p-1 border border-primary" type="text" placeholder="Titre" minlength="5" id="form_task_title" required>
                                <textarea class="form-control mt-2 p-1 border border-primary"name=""  maxlength="255" minlength="5"  rows="5" placeholder="description" name="password" id="form_task_description" required></textarea>
                                    <div class="mt-3">
                                        <label for="form_task_end_at m-0 p-0 text-gray">Date de fin :</label>
                                        <input type="datetime-local" class="m-0 p-0 form-control" name="" id="form_task_end_at">
                                    </div>
                                <div class="mt-3 d-flex justify-content-end">
                                    <button class="btn btn-sm btn-primary p-2 px-3" id="task_adder"><i class="fas fa-plus"></i>&nbsp; Ajouter</button>
                                </div> 
                            </div> 
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

    </body>
    <script>
        
    </script>
<script>
    //Constantes globales à tout le JS :
    @auth
    const user_id = {{ Auth::user()->id }} //
    @endauth
    Tasks = [] // tableau de toutes les taches de la journée
    const url_get_today = "{{ route('task.getbyday') }}"
    const url_store = "{{ route('task.save_all') }}"

    /* Définition de la classe Task*/
    class Task {
        constructor(title, description, to_end_at, created_at, user_id) {
            this.title = title;
            this.description = description;
            this.to_end_at = to_end_at;
            this.created_at = created_at;
            this.user_id = user_id;
            this.done = false;
        }
    }


    findForToday()

    function  hideSearchForm(){
        $('#SearchForm').addClass('d-none')
    }
    function  openSearchForm(){
        $('#SearchForm').removeClass('d-none')
    }

    function findForToday(){
        $.ajax({
            type: 'GET', // on précise la methode
            url: url_get_today, //l'url vers laquelle AJAX doit diriger la requette
            async:true,
            success: function(response) { // si tout se passe bien NOTE: reponse contient la réponse obtenu de la requette
                    response.forEach(element => {
                        Tasks.push(element)
                    });
                    displaysTasks() // on afiche le resultat
                },
            // on error
            error: function(response) { //sinon
                console.log("the error returned: %o", response)
            }
        });
    }

    function findHistory(){
        Tasks = []
        date = $('#hystory_date').val();
       $("#listContainer").html("")
        if (date == ""){
            alert("Vous n'avez pas sélectioné de date !")
        }else{
            $.ajax({
                type: 'GET', // on précise la methode
                url: url_get_today+"/"+$('#hystory_date').val(), //l'url vers laquelle AJAX doit diriger la requette
                async:false,
                success: function(response) { // si tout se passe bien NOTE: reponse contient la réponse obtenu de la requette
                        if(response.length == 0){
                            $("#listContainer").html("<span class='text-center'>il n'y a pas de tache enregistrée à cette date . </span>")
                            console.log("response vide")
                        
                        }else{
                            response.forEach(element => {
                                Tasks.push(element)
                            });
                            displaysTasks(mode = "history") // on afiche le resultat
                        }
                    },
                // on error
                error: function(response) { //sinon
                    console.log("the error returned: %o", response)
                }
            });
        }
    }

    //fonction pour afficher les taches :
    function displaysTasks(mode="default"){
       // toDisplay = tasks.concact(Tasks)  
       // toDisplay.forEach(element => {
       //     console.log(element)
       // });
       $("#listContainer").html("")
        i = Tasks.length
        while(i != 0){
            if(mode == "in_process" && Tasks[i-1].done){
            }

            else if(mode == "ended" && !Tasks[i-1].done){
            }
            else{
                taskNode = "<div class='my-2 bg-light task p-2 d-flex align-items-center'>  <div> "
                taskNode+="<span> <input type='checkbox' class='form control checkbox' id='"+(i-1)+"' onchange='toggleTask("+(i-1)+")' "
                if(Tasks[i-1].done){
                    taskNode+=  " checked='checked' "
                } 
                if(mode == "history"){
                    taskNode+=  " disabled = 'disabled' "
                } 
                taskNode+="> </span> <span class=''><label for='"+(i-1)+"' "
                if(Tasks[i-1].done){
                    taskNode+=  " style='text-decoration:line-through;' "
                } 
                taskNode+=" >"+Tasks[i-1].title+"</label></span></div></div> "
                                
                $("#listContainer").html($("#listContainer").html() + taskNode)
            }

            i--;
        }
    }

    // définition de la fonction datetime qui retourne la date et heure actuelle
    function datetime () {
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;
        return dateTime
    }

    //foinction pour vider le formulaire
    function resetAllFields() {
        $("#form_task_title").val("") ; 
        $("#form_task_description").val("")  ;
        $("#form_task_end_at").val("") 
        $("#form_display_error").html("")

    }

    function toggleTask(index){
        if(Tasks[index].done==true){
            Tasks[index].done=false
        }else{
            Tasks[index].done=true
        }
        displaysTasks()
    }

    $("#task_adder").on("click", event => {
        newTaskTitle =$("#form_task_title").val() ; 
        newTaskDescription =$("#form_task_description").val()  ;
        newTaskEnd =$("#form_task_end_at").val()  ;
        if(newTaskTitle ==  "" || newTaskDescription == "" || newTaskEnd == "" ){
           $("#form_display_error").html("<small>Certains champs sont vides, SVP veuillez verifier et recommencer</small>")

        }else if(new Date(newTaskEnd).getTime() <= new Date()){
           $("#form_display_error").html("<small>la date de fin ne peut pas etre inférieure à maintenant</small>")
        }
        else{
            const newTask = new Task(newTaskTitle, newTaskDescription, newTaskEnd, datetime(), user_id) //on créé un nouvelle tache
            resetAllFields() //on réinitialise le formulaire
            // on ajoute la tache à la liste de s taches
            Tasks.push(newTask)
            //on actualise la liste des taches
            displaysTasks()
            //on   affiche  un jomi méssage
            $("#form_display_success").html("<small>Bravo; vous venez d'ajouter une Tache <br> Vous pouvez en enregistrer une autre, ou cliquer sur la croix pour fermer</small>")

        }
       //$("#listContainer").html("coucou"+p.hauteur)
    })


    $("#saver").on("click", event => {
        console.log( JSON.stringify(Tasks))
        $.ajax({
            type: 'POST', // on précise la methode
            url: url_store, //l'url vers laquelle AJAX doit diriger la requette
            data: JSON.stringify(Tasks),
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            // async:false,
            // on success 
            success: function(response) { // si tout se passe bien NOTE: reponse contient la réponse obtenu de la requette
                    alert(response.success)
                },
            // on error
            error: function(response) { //sinon
                console.log("the error returned: %o", response)
            }
        });
    })

    $(document).ready(function() {
        $(".nav-menu").click(function(event) {
                for (let i = 0; i < $(".nav-menu").length; i++) {
                $(".nav-menu")[i].classList.remove("bg-white");
                $(".nav-menu")[i].classList.remove("text-dark");
                //.removeClass('bg-white text-dark')
            } 
            $(this).addClass('bg-white text-dark')
        });
    });
</script>

</html>
