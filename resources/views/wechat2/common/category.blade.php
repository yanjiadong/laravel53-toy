<nav class="index-nav">
    <ul class="nav">
        {{--<li class="active">
            <a href="index.html">推荐</a>
        </li>
        <li>
            <a href="sort_detail.html">成长陪护</a>
        </li>
        <li>
            <a href="sort_detail.html">早教学习</a>
        </li>
        <li>
            <a href="sort_detail.html">智力开发</a>
        </li>
        <li>
            <a href="sort_detail.html">智力开发1</a>
        </li>
        <li>
            <a href="javascript:;">智力开发2</a>
        </li>
        <li>
            <a href="javascript:;">智力开发2</a>
        </li>
        <li>
            <a href="javascript:;">智力开发2</a>
        </li>
        <li>
            <a href="javascript:;">智力开发2</a>
        </li>
        <li>
            <a href="sort_detail.html">智力开发2</a>
        </li>
        <li>
            <a href="javascript:;">智力开发2</a>
        </li>--}}
    </ul>
</nav>
<script type="text/javascript">
    //加载分类
    var sortList = [],cont='';
    common.httpRequest('{{url('api/index/categories')}}','post',null,function (res) {
        var category_menu = '{{isset($category_id)?$category_id:'index'}}';

        if(category_menu == 'index')
        {
            cont = '<li class="active"><a href="{{ route('wechat.index.index') }}">推荐</a></li>';
        }
        else
        {
            cont = '<li class=""><a href="{{ route('wechat.index.index') }}">推荐</a></li>';
        }

        var sortList = res.info.categorys;
        console.log(sortList);
        var category_id = '{{isset($category_id)?$category_id:0}}';
        for(var i=0;i<sortList.length;i++){
            if(sortList[i].id == category_id)
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

        //顶部导航选择
        $(".index-nav .nav").scrollLeft(localStorage.index_nav_left?localStorage.index_nav_left:0);
        $(".index-nav .nav li").click(function () {
            var moveX = $(this).position().left+$(this).closest('.index-nav .nav').scrollLeft();
            var pageX = document.documentElement.clientWidth;
            var blockWidth = $(this).width();
            var left = moveX-(pageX/2)+(blockWidth/2);
            localStorage.index_nav_left = left;
            $(".index-nav .nav").scrollLeft(left);
            $(".index-nav .nav li").removeClass('active');
            $(this).addClass('active');
        });
    })
</script>