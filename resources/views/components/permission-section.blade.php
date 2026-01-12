
@props(['title', 'range', 'role' => null])

<div class="mb-3">
  <h6 class="fw-bold mb-2">{{ $title }}</h6>
  <div class="row">
    @foreach(\Spatie\Permission\Models\Permission::whereBetween('id', $range)->get() as $permission)
      <div class="col-md-4 mb-2">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
            @if($role && $role->permissions->contains('name', $permission->name)) checked @endif>
          <label class="form-check-label">{{ $permission->name }}</label>
        </div>
      </div>
    @endforeach
  </div>
</div>
