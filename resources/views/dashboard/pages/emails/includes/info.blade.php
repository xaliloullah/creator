<div class="row">

    <div class="form-group col-lg-12">
        <label class="form-label" for="titre">titre</label>
        <input class="form-control" id="titre" name="data[titre]" type="text" value="{{ $data['titre'] ?? '' }}">
    </div>
    <div class="form-group col-lg-12">
        <label class="form-label" for="subject">subject</label>
        <input class="form-control" id="subject" name="subject" type="text" value="{{ $email->subject }}">
    </div>
    <div class="form-group col-lg-12">
        <label class="form-label" for="message">Message</label>
        <textarea class="form-control editor" id="message" name="data[message]">{!! $data['message'] ?? '' !!}</textarea>
    </div>

</div>
