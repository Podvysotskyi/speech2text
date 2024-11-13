@foreach($transcriptions as $transcription)
{{ $transcription->speaker->name }}:
{{ $transcription->text }}

@endforeach
