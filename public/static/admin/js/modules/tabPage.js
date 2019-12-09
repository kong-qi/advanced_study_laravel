layui.define(['element', 'cacheNav', 'md5'], function (exports) {
    var cacheNav = layui.cacheNav;
    var md5 = layui.md5;
    var TABS_HEADER_UL = 'admin-app-tab-header';//标签页tabs ul
    var TABS_BODY_ITEM = 'admin-tabs-body-item';//iframe item
    var ADMIN_BODY = '#admin-app-body';//主页面ID
    var FILTER_TAB_TBAS = 'admin-layout-tabs';//标签页tabs filter
    var SHOW = 'layui-show';//显示
    var element = layui.element;
    var $=layui.jquery;
    var tabPage = {
        //记录最近一次点击的页面标签数据
        tabsPage: {},
        tabsBody: function (index) {
            return $(ADMIN_BODY).find('.' + TABS_BODY_ITEM).eq(index || 0);
        },
        //关闭当前页面
        closeThisTabs: function () {
            var that = this;
            if (!that.tabsPage.index) return;
            var itemObj=$("#"+TABS_HEADER_UL+" li").eq(that.tabsPage.index);
            var key = md5.md5(itemObj.attr('lay-id'));

            if (key) {
                cacheNav.deleteKey(key);
            }


           $('#'+TABS_HEADER_UL+' li').eq(that.tabsPage.index).find('.layui-tab-close').trigger('click');
        }
        //记录最近一次点击的页面标签数据

        //关闭其它标签页
        , closeOtherTabs: function (type) {
            var that = this;
            var TABS_REMOVE = 'admin-system-pagetabs-remove';
            if (type === 'all') {
                $('#'+TABS_HEADER_UL+' li:gt(0)').remove();
                $(ADMIN_BODY).find('.' + TABS_BODY_ITEM + ':gt(0)').remove();
                $("#admin-app-tab-header li").eq(0).trigger('click');
                //清空缓存
                cacheNav.clearAll();
            } else {
                $('#'+TABS_HEADER_UL+' li').each(function (index, item) {
                    if (index && index != that.tabsPage.index) {
                        $(item).addClass(TABS_REMOVE);
                        that.tabsBody(index).addClass(TABS_REMOVE);
                    }
                    var itemObj = $("#"+TABS_HEADER_UL+" li").eq(that.tabsPage.index);
                    var key = md5.md5(itemObj.attr('lay-id'));
                    var text = itemObj.find('span').text();
                    var href = itemObj.attr('lay-id');

                    if (key) {
                        cacheNav.clearOther(key, text.replace(/(^\s*)|(\s*$)/g, ""), href);
                    }
                });
                $('.' + TABS_REMOVE).remove();
            }
        }

        //关闭全部标签页
        , closeAllTabs: function () {
            this.closeOtherTabs('all');
            //location.hash = '';
        }
        //打开标签页
        , openTabsPage: function (url, text) {
            var that = this;
            //遍历页签选项卡
            var matchTo
                , tabs = $('#' + TABS_HEADER_UL + '>li')
                , path = url.replace(/(^http(s*):)|(\?[\s\S]*$)/g, '');

            tabs.each(function (index) {
                var li = $(this)
                    , layid = li.attr('lay-id');

                if (layid === url) {
                    matchTo = true;
                    that.tabsPage.index = index;
                }
            });

            text = text || '新标签页';
            //是否开启页面选项卡功能
            if (!matchTo) {
                $(ADMIN_BODY).append([
                    '<div class="admin-tabs-body-item layui-show">'
                    , '<iframe src="' + url + '" frameborder="0" class="admin-iframe"></iframe>'
                    , '</div>'
                ].join(''));
                that.tabsPage.index = tabs.length;
                //layadmin-layout-tabs
                element.tabAdd(FILTER_TAB_TBAS, {
                    title: '<span>' + text + '</span>'
                    , id: url
                    , attr: path
                });
            }

            //定位当前tabs
            element.tabChange(FILTER_TAB_TBAS, url);
            that.tabsBodyChange(that.tabsPage.index, {
                url: url
                , text: text
            });
        } //切换页面标签主体
        , tabsBodyChange: function (index, options) {
            var that = this;
            that.tabsBody(index).addClass(SHOW).siblings().removeClass(SHOW);
            that.rollPage('auto', index);
        }
        //左右滚动页面标签
        , rollPage: function (type, index) {
            var tabsHeader = $('#' + TABS_HEADER_UL)
                , liItem = tabsHeader.children('li')
                , scrollWidth = tabsHeader.prop('scrollWidth')
                , outerWidth = tabsHeader.outerWidth()
                , tabsLeft = parseFloat(tabsHeader.css('left'));

            //右左往右
            if (type === 'left') {
                if (!tabsLeft && tabsLeft <= 0) return;

                //当前的left减去可视宽度，用于与上一轮的页标比较
                var prefLeft = -tabsLeft - outerWidth;

                liItem.each(function (index, item) {
                    var li = $(item)
                        , left = li.position().left;

                    if (left >= prefLeft) {
                        tabsHeader.css('left', -left);
                        return false;
                    }
                });
            } else if (type === 'auto') { //自动滚动
                (function () {
                    var thisLi = liItem.eq(index), thisLeft;

                    if (!thisLi[0]) return;
                    thisLeft = thisLi.position().left;

                    //当目标标签在可视区域左侧时
                    if (thisLeft < -tabsLeft) {
                        return tabsHeader.css('left', -thisLeft);
                    }

                    //当目标标签在可视区域右侧时
                    if (thisLeft + thisLi.outerWidth() >= outerWidth - tabsLeft) {
                        var subLeft = thisLeft + thisLi.outerWidth() - (outerWidth - tabsLeft);
                        liItem.each(function (i, item) {
                            var li = $(item)
                                , left = li.position().left;

                            //从当前可视区域的最左第二个节点遍历，如果减去最左节点的差 > 目标在右侧不可见的宽度，则将该节点放置可视区域最左
                            if (left + tabsLeft > 0) {
                                if (left - tabsLeft > subLeft) {
                                    tabsHeader.css('left', -left);
                                    return false;
                                }
                            }
                        });
                    }
                }());
            } else {
                //默认向左滚动
                liItem.each(function (i, item) {
                    var li = $(item)
                        , left = li.position().left;

                    if (left + li.outerWidth() >= outerWidth - tabsLeft) {
                        tabsHeader.css('left', -left);
                        return false;
                    }
                });
            }
        }
        //向右滚动页面标签
        , leftPage: function () {
            this.rollPage('left');
        }

        //向左滚动页面标签
        , rightPage: function () {
            this.rollPage();
        },
        //到达页面
        goPage: function (othis) {
            var layid = othis.attr('lay-id')
                , attr = othis.attr('lay-attr')
                , index = othis.index();

            this.tabsBodyChange(index, {
                url: attr
            });

        }
    }

    //监听标签页删除
    element.on('tabDelete(' + FILTER_TAB_TBAS + ')', function (obj) {
        var othis = $(TABS_HEADER_UL + '.layui-this');

        obj.index && tabPage.tabsBody(obj.index).remove();
        tabPage.goPage(othis);
        var itemObj = $(this).parent("li");
        var key = md5.md5(itemObj.attr('lay-id'));
        cacheNav.deleteKey(key);

    });
    //监听 tab 组件切换
    element.on('tab(' + FILTER_TAB_TBAS + ')', function (data) {
        tabPage.tabsPage.index = data.index;
    });
    //页面跳转
    $("body").on('click', '*[admin-href]', function () {
        var othis = $(this)
            , href = othis.attr('admin-href')
            , text = othis.attr('admin-text') || othis.text()
            , router = layui.router();

        tabPage.tabsPage.elem = othis;

        //记录存储已经打开，刷新的时候，执行打开
        var key = md5.md5(href);
        //设置
        cacheNav.set(key, (text || othis.text()).replace(/(^\s*)|(\s*$)/g, ""), href)
        cacheNav.setOn(key);
        //执行跳转
        tabPage.openTabsPage(href, text || othis.text());
    });
    //左边滚动
    $('[tabPage-event="leftPage"]').click(function () {
        tabPage.leftPage();
    });
    //右边
    $('[tabPage-event="rightPage"]').click(function () {
        tabPage.rightPage();
    });
    //关闭当前页面
    $('[tabpage-event="closeThis"]').click(function(){
        tabPage.closeThisTabs();
    })
    //关闭当前页面
    $('[tabpage-event="closeOther"]').click(function(){
        tabPage.closeOtherTabs('other');
    })
    //关闭全部
    $('[tabpage-event="closeAllTabs"]').click(function(){
        tabPage.closeOtherTabs('all');
    })
    //标签页标题点击
    $("body").on('click', '#' + TABS_HEADER_UL + '>li', function () {
        var othis = $(this)
            , index = othis.index();
        tabPage.type = 'tab';
        tabPage.index = index;
        tabPage.goPage(othis);
        var href = othis.attr('lay-id');
        var text = othis.attr('admin-text') || othis.text()
        var key = md5.md5(href);
        //设置
        cacheNav.set(key, (text || othis.text()).replace(/(^\s*)|(\s*$)/g, ""), href)
        //后续再补充
        cacheNav.setOn(key);
    });
    //双击标签页刷新
    $(document).on('dblclick', '#' + TABS_HEADER_UL + '>li', function () {
        var ELEM_IFRAME = '.admin-iframe'
            , length = $('.' + TABS_BODY_ITEM).length;
        if (tabPage.tabsPage.index >= length) {
            tabPage.tabsPage.index = length - 1;
        }
        var iframe = tabPage.tabsBody(tabPage.tabsPage.index).find(ELEM_IFRAME);
        console.log(iframe.html());
        iframe[0].contentWindow.location.reload(true);
    });

    //加载缓存的navs
    var cacheOpenTabsPage = function () {

        //判断是否存在缓存
        var cache_navs = cacheNav.get();

        if (cache_navs) {

            var item_key = cacheNav.getOn();
            //进行输出变量
            var top_tab_str = '';
            for (var i in cache_navs) {
                var item = cache_navs[i];

                if (item && item.href) {
                    item.title=item.title.replace(/ဆ/,'');
                    //console.log('名字1'+item.title);
                    //插入顶部tabs
                    tabPage.openTabsPage(item.href, item.title)
                    cacheNav.setOn(item_key);
                }

            }
            //设置最后一个定位
            item_key = cacheNav.getOn();
            item = cache_navs[item_key];


            if (item && item.href) {
                if(typeof item.title !='undefined')
                {
                    item.title=item.title.replace(/ဆ/,'');
                    // console.log('名字'+item.title);
                }

                tabPage.openTabsPage(item.href, item.title)
            }

        }
    };
    cacheOpenTabsPage();

    exports('tabPage', tabPage);
});
