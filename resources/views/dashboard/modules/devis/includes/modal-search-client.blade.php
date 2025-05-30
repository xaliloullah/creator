<form id="search-client-form" action="{{ route('clients.search') }}" method="POST">
    @csrf
    <input type="hidden" name="mode" value="select" id="mode">
    <div class="modal fade" id="modal-search-client" tabindex="-1" aria-labelledby="modal-search-client-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header"> 
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Rechercher un client" name="query"
                            aria-label="Rechercher un client" aria-describedby="rechercher-un-client" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="rechercher-un-client"><i
                                    class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="search-clients-results">

                    </div>
                    <script>
                        document.getElementById('search-client-form').addEventListener('submit', function(event) {
                            event.preventDefault();
                            let form = this;
                            let formData = new FormData(form);
                            let resultDiv = document.getElementById('search-clients-results');
                            fetch(form.action, {
                                    method: form.method,
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => response.text())
                                .then(html => {
                                    document.getElementById("search-clients-results").innerHTML = html;
                                })
                                .catch(error => {
                                    console.error("Erreur lors de la recherche :", error);
                                });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</form>
