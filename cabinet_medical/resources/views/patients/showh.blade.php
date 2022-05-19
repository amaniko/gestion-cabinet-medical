<div class="modal-header">
    <h5 class="modal-title" id="update2">Consultation</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form action="{{ route('patients.update',$historique->id) }}" method="POST">
    @csrf 
    @method('PUT')
    <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
    <strong style="text-align: center ">Date du rendez-vous : </strong>
    <strong style="text-align: center; margin-bottom: 0.5em;">{{ $historique->dateRV}}</strong>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <strong style="text-align: center ">Pathologie détectée: </strong>
        <strong style="text-align: center;margin-bottom: 0.5em;">{{ $historique->pathologie}}</strong>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
    <strong>actes médicaux réalisés : </strong>
    <strong style="text-align: center;margin-bottom: 0.5em;">{{ $historique->actes_chirurgicaux}}</strong>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
    <strong>examens médicaux demandés : </strong>
    <strong style="text-align: center;margin-bottom: 0.5em;">{{ $historique->examens}}</strong>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
    <strong>assurrance utilisée : </strong>
    <strong style="text-align: center;margin-bottom: 0.5em;">{{ $historique->assurrance}}</strong>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
    <strong>Remarques : </strong>
    <strong style="text-align: center;margin-bottom: 0.5em;">{{ $historique->Remarque}}</strong>
    </div>
    </div>
    </div>
    </form>
    