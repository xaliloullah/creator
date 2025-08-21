@if ($clients->isNotEmpty())
    <div class="row">
        @foreach ($clients as $client)
            @php
                if ($mode == 'select') {
                    $href = 'javascript:void(0);';
                    $action = "document.getElementById('client_id').value = '$client->id';
                    document.getElementById('client_name').value = '$client->prenom $client->nom';
                    ";
                } else {
                    $href = route('clients.show', $client->id);
                    $action = '';
                }
                $adresse = json_decode($client->adresse, true);
                $telephones = json_decode($client->telephones, true) ?? [];
            @endphp
            <a href="{{ $href }}" class="card m-2 shadow" style="width: 15rem;" data-dismiss="modal"
                onclick="{{ $action }}">
                <img src="{{ asset('assets/images/' . ($client->image ? 'clients/' . $client->image : 'default-user.png')) }}"
                    class="card-img-top" alt="...">
                <div class="card-body">
                    <h6 class="card-title">{{ $client->prenom }} {{ $client->nom }}</h6>
                    <p><small class="card-text">{{ $client->email }}</small></p>
                    <p>
                        @foreach ($telephones as $telephone)
                            <small>{{ $telephone }}</small><br>
                        @endforeach
                    </p>
                    <p><small
                            class="card-text">{{ implode(' ', [
                                $adresse['rue'],
                                $adresse['complement'],
                                $adresse['code_postal'],
                                $adresse['ville'],
                                $adresse['pays'],
                            ]) }}
                        </small>
                    </p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="text-center"><small>{{ $clients->count() }}</small></div>
@else
    <div class="alert alert-warning">
        Aucun client trouvé.
    </div>
@endif


{{--
<script>
    function select(element) {
        document.getElementById("client_id").value = element.getAttribute("data-client-id");
        document.getElementById("client_name").value = element.getAttribute("data-client-name");
        document.getElementById("client_email").value = element.getAttribute("data-client-email");
        document.getElementById("client_adresse").value = element.getAttribute("data-client-adresse");
        document.getElementById("client_contact").value = element.getAttribute("data-client-contact");
        document.getElementById("client_image").src = element.getAttribute("data-client-image");
    }
</script> --}}
