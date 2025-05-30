{{-- <link href="{{ asset('assets/css/images.css') }}" rel="stylesheet"> --}}
{{-- <script src="{{ asset('assets/js/images.js') }}"></script> --}}

<div class="modal fade" id="components-modal" tabindex="-1" role="dialog" aria-labelledby="components-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title">Components</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs nav-fill" id="parametre" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="images-ui-tab" data-bs-toggle="tab"
                            data-bs-target="#images-ui" type="button" role="tab" aria-controls="images-ui"
                            aria-selected="true">Images</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="table-ui-tab" data-bs-toggle="tab" data-bs-target="#table-ui"
                            type="button" role="tab" aria-controls="table-ui" aria-selected="false">Tables</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="form-ui-tab" data-bs-toggle="tab" data-bs-target="#form-ui"
                            type="button" role="tab" aria-controls="form-ui" aria-selected="false">Form</button>
                    </li>
                </ul>
                <div class="tab-content" id="components-content">
                    <div class="tab-pane fade show active" id="images-ui" role="tabpanel"
                        aria-labelledby="images-ui-tab" tabindex="0">
                        <div class="container p-4">
                            <div class="row text-center">
                                <div class="col-2">
                                    <div class="image-container rounded-pill">
                                        <img src="{{ asset('assets/images/default-user.png') }}" alt="Image"
                                            class="image-preview image1 mx-auto d-block" />
                                        <label for="image1" class="image-overlay">
                                            <i class="bi bi-camera-fill fs-3"></i>
                                        </label>
                                        <input type="file" id="image1" accept="image/*" class="image-input" />
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="image-container rounded">
                                        <img src="{{ asset('assets/images/default.png') }}" alt="Image"
                                            class="image-preview image2 mx-auto d-block" />
                                        <label for="image2" class="image-overlay">
                                            <i class="bi bi-camera-fill fs-3"></i>
                                        </label>
                                        <input type="file" id="image2" accept="image/*" class="image-input" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container py-4 text-center">
                            <h1 class="mb-4">Dropzone</h1>
                            {{-- <div id="dropzone" class="dropzone">
                                <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                                <h6>Déposez les images ici ou cliquez pour télécharger</h6>
                                <p class="text-muted"><small>Formats acceptés : JPG, PNG, GIF (Max 5MB par
                                        image)</small></p>
                                <input type="file" id="dropzone-input" multiple accept="image/*" hidden>
                                <div id="dropzone-container" class="dropzone-container"></div>
                            </div> --}}
                            <div {{-- id="dropzone" --}} class="dropzone">
                                <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                                <h6>Déposez les images ici ou cliquez pour télécharger</h6>
                                <p class="text-muted"><small>Formats acceptés : JPG, PNG, GIF (Max 5MB par
                                        image)</small></p>
                                {{-- <input type="file" id="dropzone-input" multiple accept="image/*" hidden> --}}
                                <div {{-- id="dropzone-container" --}} class="dropzone-container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="table-ui" role="tabpanel" aria-labelledby="table-ui-tab"
                        tabindex="0">
                        <div class="container p-4">
                            <div class="table-responsive card shadow">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="card-head">
                                        <tr>
                                            <th scope="col">Column 1</th>
                                            <th scope="col">Column 2</th>
                                            <th scope="col">Column 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <td scope="row">R1C1</td>
                                            <td>R1C2</td>
                                            <td>R1C3</td>
                                        </tr>
                                        <tr class="">
                                            <td scope="row">Item</td>
                                            <td>Item</td>
                                            <td>Item</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="form-ui" role="tabpanel" aria-labelledby="form-ui-tab"
                        tabindex="0">
                        <form action="#" class="p-4">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="texte" class="form-label">Texte :</label>
                                    <input type="text" class="form-control" id="texte" name="texte"
                                        required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="password" class="form-label">Mot de passe :</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="email" class="form-label">Email :</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="search" class="form-label">Search :</label>
                                    <input type="search" class="form-control form-control-sm" id="search"
                                        name="search" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="url" class="form-label">URL :</label>
                                    <input type="url" class="form-control" id="url" name="url"
                                        required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="tel" class="form-label">Téléphone :</label>
                                    <input type="tel" class="form-control" id="tel" name="tel"
                                        required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre :</label>
                                    <input type="number" class="form-control" id="nombre" name="nombre"
                                        min="0" max="10" step="1" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="button" class="btn btn-primary" value="primary">
                                <input type="button" class="btn btn-secondary" value="secondary">
                                <input type="button" class="btn btn-success" value="success">
                                <input type="button" class="btn btn-warning" value="warning">
                                <input type="button" class="btn btn-danger" value="danger">
                                <input type="button" class="btn btn-info" value="info">
                                <input type="button" class="btn btn-light" value="light">
                                <input type="button" class="btn btn-dark" value="dark">
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="case" name="case"
                                        value="coche" required>
                                    <label class="form-check-label" for="case">Case à cocher :</label>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Radio :</label><br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="radio1" name="radio"
                                            value="option1" checked>
                                        <label class="form-check-label" for="radio1">Option 1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="radio2" name="radio"
                                            value="option2">
                                        <label class="form-check-label" for="radio2">Option 2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="fichier" class="form-label">Fichier :</label>
                                    <input type="file" class="form-control" id="fichier" name="fichier"
                                        required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="fichier" class="form-label">Fichier multiple:</label>
                                    <input type="file" class="form-control" id="fichier" name="fichier"
                                        multiple required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="select" class="form-label">Select :</label>
                                    <select class="form-control" name="select" id="select">
                                        <option value="select1" selected>select1</option>
                                        <option value="select2">select2</option>
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="select" class="form-label">Tags :</label>
                                    <select class="form-control tags" name="Tags" id="tags" multiple>
                                        <option value="select1" selected>select1</option>
                                        <option value="select2">select2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image :</label><br>
                                <input type="image" src="{{ asset('assets/images/default.png') }}"
                                    class="img-thumbnail" alt="Bouton d'image" width="50" required>
                            </div>

                            <div class="row">
                                <div class="col-2 mb-3">
                                    <label for="date" class="form-label">Date :</label>
                                    <input type="date" class="form-control" id="date" name="date">
                                </div>

                                <div class="col-2 mb-3">
                                    <label for="datetime-local" class="form-label">Datetime-local :</label>
                                    <input type="datetime-local" class="form-control" id="datetime-local"
                                        name="datetime-local" required>
                                </div>

                                <div class="col-2 mb-3">
                                    <label for="month" class="form-label">Month :</label>
                                    <input type="month" class="form-control" id="month" name="month"
                                        required>
                                </div>

                                <div class="col-2 mb-3">
                                    <label for="week" class="form-label">Week :</label>
                                    <input type="week" class="form-control" id="week" name="week"
                                        required>
                                </div>

                                <div class="col-2 mb-3">
                                    <label for="heure" class="form-label">Heure :</label>
                                    <input type="time" class="form-control" id="heure" name="heure"
                                        required>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="couleur" class="form-label">Couleur :</label>
                                    <input type="color" class="form-control form-control-color" id="couleur"
                                        name="couleur" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="range" class="form-label">Plage de valeurs :</label>
                                    <input type="range" class="form-range" id="range" name="range"
                                        min="0" max="100" step="1" value="50">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="hidden" class="form-label">Champ caché :</label>
                                <input type="hidden" id="hidden" name="hidden" value="hidden">
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="zone" class="form-label">Zone de texte :</label>
                                    <textarea class="form-control" id="zone" name="zone" rows="5" required></textarea>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="zone" class="form-label">Editor :</label>
                                    <textarea class="form-control editor" id="zone" name="zone" rows="5" required></textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="submit" class="btn btn-success" value="Soumettre">
                                <input type="reset" class="btn btn-secondary" value="Réinitialiser">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
