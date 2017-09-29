<nav class="index-nav">
    <ul class="nav">
        <!--   <li class="active">
               <a href="index.html">推荐</a>
           </li>
           <li  data-tab="1">
               <a href="sort_detail.html">成长陪护</a>
           </li>
           <li  data-tab="2">
               <a href="javascript:;">早教学习</a>
           </li>
           <li  data-tab="3">
               <a href="javascript:;">智力开发</a>
           </li>
           <li  data-tab="4">
               <a href="javascript:;">智力开发1</a>
           </li>
           <li  data-tab="5">
               <a href="javascript:;">智力开发2</a>
           </li>-->
    </ul>
</nav>

<script type="text/javascript">
    //加载分类
    var sortList = [],cont='';
    common.httpRequest('{{url('api/index')}}','get',null,function (res) {
        var category_menu = '{{isset($category_id)?$category_id:'index'}}';

        if(category_menu == 'index')
        {
            cont = '<li class="active"><a href="{{ route('wechat.index.index') }}">推荐</a></li>';
        }
        else
        {
            cont = '<li class=""><a href="{{ route('wechat.index.index') }}">推荐</a></li>';
        }

        //假数据
        /*sortList = [
            {id:1,name:'推荐'},
            {id:2,name:'成长陪护'},
            {id:3,name:'早教学习'},
            {id:4,name:'推荐1'},
            {id:5,name:'成长陪护1'},
            {id:6,name:'早教学习1'}
        ];*/
        var sortList = res.info.categorys;
        for(var i=0;i<sortList.length;i++){
            if(sortList[i].id == '{{$category_id}}')
            {
                cont += '<li class="active"><a href="{{route('wechat.index.category')}}'+'/'+sortList[i].id+'/0">'+sortList[i].title+'</a></li>';
            }
            else
            {
                cont += '<li><a href="{{route('wechat.index.category')}}'+'/'+sortList[i].id+'/0">'+sortList[i].title+'</a></li>';
            }

        }
        $('.index-nav .nav').html(cont);


        //确定ul的长度
        var wid=0;
        var $li =$('.index-nav .nav li');
        if($li.length>0){
            for(var i=0;i<$li.length;i++){
                wid +=$($li[i]).outerWidth();
            }
            $('.index-nav .nav').width(wid+'px');
        }
    })
</script>