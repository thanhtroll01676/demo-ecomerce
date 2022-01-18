@role('owner')
<h1>Tôi có role là <strong style="color: red;">owner</strong></h1>
@endrole
@role('admin')
<h1>Tôi có role là <strong style="color: red;">admin</strong></h1>
@endrole

@permission('upload')
<div>
    Vì có quyền <strong>upload</strong> nên mới hiện ra cái này:
    <input type="file">
</div>
<br>
@endpermission

@ability('admin', 'upload')
<div>
    Có role là <strong>admin</strong> <u>hoặc</u> có quyền <strong>upload</strong> đều hiện ra cái này:
    <input type="file">
</div>
<br>
@endability

@ability('admin', 'upload', ['validate_all' => true])
<div>
    Có role là <strong>admin</strong> <u>và</u> có quyền <strong>upload</strong> đều hiện ra cái này:
    <input type="file">
</div>
<br>
@endability

@ability('admin,owner', 'upload')
<div>
    Bất kỳ là có role là <strong>admin</strong> <u>hoặc</u> <strong>owner</strong> <u>hoặc</u> có quyền <strong>upload</strong> đều hiện ra cái này:
    <input type="file">
</div>
<br>
@endability

@ability('admin,owner', 'upload', ['validate_all' => true])
<div>
    Là <strong>admin & owner & upload</strong> mới hiện ra cái này:
    <input type="file">
</div>
<br>
@endability


