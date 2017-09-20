<div class="form-group input-sort">
    <label>{{$title}}</label>
   <ul id="sortable-{{$slug}}" class="container-fluid">

       @if(!isset($value) || is_null($value))
               <li class="ui-state-default form-group row">
                   <span onclick="return false;" class="btn btn-link col-xs-1 pull"><i class="fa-bars fa"></i></span>
                   <input type="text" class="form-control col-xs-10"
                          @if(isset($prefix))
                          name="{{$prefix}}[{{$lang}}]{{$name}}[0]"
                          @else
                          name="{{$lang}}{{$name}}[0]"
                          @endif
                   >
                   <button class="btn btn-link col-xs-1 remove" onclick="removeitem{{$slug}}(this)"><i class="icon-trash fa"></i></button>
               </li>
       @else
           @foreach($value as $key => $val)
               <li class="ui-state-default form-group row">
                    <span onclick="return false;" class="btn btn-link col-xs-1 pull"><i class="fa-bars fa"></i></span>
                    <input type="text" class="form-control col-xs-10"
                           @if(isset($prefix))
                           name="{{$prefix}}[{{$lang}}]{{$name}}[0]"
                           @else
                           name="{{$lang}}{{$name}}[{{$key}}]"
                           @endif
                           value="{{$val}}">
                    <button class="btn btn-link col-xs-1 remove" onclick="removeitem{{$slug}}(this)"><i class="icon-trash fa"></i></button>
                </li>
           @endforeach
       @endif
    </ul>
    <div class="button-group text-center">
        <button onclick="newitem{{$slug}}()" class="btn btn-xs alert-info">Add new</button>
    </div>
</div>
<div class="line line-dashed b-b line-lg"></div>
<style>
    .input-sort li{
        list-style: none;
    }
    .input-sort .form-control {
        width: 83.33333333%;
    }
</style>
@push('scripts')
<script>
    function newitem{{$slug}}() {
        event.preventDefault();
        let item = '<li class="ui-state-default form-group row">\n' +
            '            <span onclick="return false;" class="btn btn-link col-xs-1 pull"><i class="fa-bars fa"></i></span>\n' +
            '            <input type="text" class="form-control col-xs-10" name="" value="">\n' +
            '            <button class="btn btn-link col-xs-1 remove" onclick="removeitem{{$slug}}(this)"><i class="icon-trash fa"></i></button>\n' +
            '        </li>';
        $('#sortable-{{$slug}}').append(item);
        $("#sortable-{{$slug}} li").each(function (li) {
            $(this).find('input').attr({'name': '{{$prefix}}[{{$lang}}][{{$slug}}]['+li+']'})
        })
    }
    function removeitem{{$slug}}(item) {
        event.preventDefault();
        $(item).parent().remove();

        $("#sortable-{{$slug}} li").each(function (li) {
            $(this).find('input').attr({'name': '{{$prefix}}[{{$lang}}][{{$slug}}]['+li+']'})
        })
    }
    $(function() {
        $( "#sortable-{{$slug}}" ).sortable({
            placeholder: "ui-sortable-placeholder",
            axis: "y",
            update:function(event,ui){
                $("#sortable-{{$slug}} li").each(function (li) {
                    $(this).find('input').attr({'name': '{{$prefix}}[{{$lang}}][{{$slug}}]['+li+']'})
                })
            }
        });
    });
</script>
@endpush
