@include('base::utils.tips.max-size')
<br>
Максимальное количество одновременно загружаемых файлов: {{ (int)ini_get('max_file_uploads') }}