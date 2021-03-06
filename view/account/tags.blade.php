@section('title')
标签设置
@endsection

@extends('pcview::layouts.default')

@section('styles')
<link rel="stylesheet" href="{{ asset('zhiyicx/plus-component-pc/css/account.css')}}"/>
@endsection

@section('content')

<div class="account_container">

    @include('pcview::account.sidebar')

    <div class="account_r">
        <div class="account_c_c">
            <div class="account_tab">
                <div class="perfect_title">
                    <p>选择标签</p>
                </div>
                @foreach ($tags as $tag)
                    <div class="perfect_row">
                        <label>{{$tag->name}}</label>
                        <ul class="perfect_label_list" id="J-tags">
                        @foreach ($tag->tags as $item)
                            <li class="tag_{{$item->id}}
                            @foreach ($user_tag as $t)
                                @if ($t->name == $item->name) active @endif
                            @endforeach" data-id="{{$item->id}}">{{$item->name}}</li>
                        @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <p class="mt20 font14 tcolor">最多可选5个标签，已选 <font class="mcolor num">{{ $user_tag->count() }}</font> 个</p>
            <ul class="selected-box">
                @foreach ($user_tag as $item)
                    <li class="taged{{$item->id}}" data-id="{{$item->id}}">{{$item->name}}</li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
$('#J-tags li').on('click', function(e){
    var _this = $(this);
    var tag_id = $(this).data('id');
    var tag_name = $(this).text();
    var lenth = $('#J-tags li.active').length;
    if (_this.hasClass('active')) {
        $.ajax({
            url: '/api/v2/user/tags/'+tag_id,
            type: 'DELETE',
            dataType: 'json',
            error: function(xml) {
                noticebox('操作失败', 0, 'refresh');
            },
            success: function(res) {
                $('.num').text(lenth-1);
                _this.removeClass('active');
                $('.taged'+tag_id).remove();
            }
        });
    } else {
        if (lenth >= 5) {
            noticebox('个人标签最多选择５个', 0);
            return false;
        }
        $.ajax({
            url: '/api/v2/user/tags/'+tag_id,
            type: 'PUT',
            dataType: 'json',
            error: function(xml) {
                noticebox('操作失败', 0, 'refresh');
            },
            success: function(res) {
                _this.addClass('active');
                $('.num').text(lenth+1);
                $('.selected-box').append('<li class="taged'+tag_id+'" data-id="'+tag_id+'">'+tag_name+'</li>');
            }
        });
    }
});

$('.selected-box').on('click', 'li', function(){
    var _self = this;
    var tid = $(_self).data('id');
    var lenth = $('#J-tags li.active').length;
    $.ajax({
        url: '/api/v2/user/tags/'+tid,
        type: 'DELETE',
        dataType: 'json',
        success: function(res) {
            $(_self).remove();
            $('.num').text(lenth-1);
            $('.tag_'+tid).removeClass('active');
        }
    });
});

</script>
@endsection