<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('welcome');
});
Route::post('login','AuthenticateController@login');
Route::any('register','AuthenticateController@register');

Route::group( [ 'prefix' => '' , 'middleware' => 'jwt.auth' ] , function( ){
    //认证是否登录
    Route::any('userInfo','AuthenticateController@userInfo');
});


//产品监控
Route::group( [ 'prefix' => 'monitor' , 'middleware' => 'jwt.auth' ] , function( ){
    //监控产品列表
    Route::any('productdetail','MonitorProduct\ProductController@productdetail');
    //添加监控产品
    Route::any('addasin','MonitorProduct\ProductController@addAsin');
    //取消监控产品
    Route::any('cancelasin','MonitorProduct\ProductController@cancelAsin');
    //产品及变体详情
    Route::any('asindetail','MonitorProduct\ProductController@asinDetail');
    //bsr category信息
    Route::any('bsrinfo','MonitorProduct\ProductController@bsrInfo');
    //图表
    Route::any('graph','MonitorProduct\ProductController@graph');
    //变体信息
    Route::any('variantlist','MonitorProduct\ProductController@variantList');
    //评论分析 listing评论列表
    Route::any('reviewgraph','MonitorProduct\ProductController@reviewGraph');
    //卖点分析
    Route::any('reviewinfo','MonitorProduct\ProductController@reviewInfo');
    //tag标签新增
    Route::any('reviewTaginsert','MonitorProduct\ProductController@reviewTagInsert');
    //tag标签查询
    Route::any('reviewTagshow','MonitorProduct\ProductController@reviewTagShow');
    //关键词插入
    Route::any('insertkeywords','MonitorProduct\ProductController@insertKeywords');
    //用户监控的关键词排名曲线图
    Route::any('userkeywordratechart','MonitorProduct\ProductController@userKeywordRateChart');
    //用户监控的关键词排名
    Route::any('userkeywordrate','MonitorProduct\ProductController@userKeywordRate');
    //评论饼状图
    Route::any('reviewpie','MonitorProduct\ProductController@reviewPie');
    //listing其余卖家详情
    Route::any('asinotherseller','MonitorProduct\ProductController@asinOtherSeller');
    //review列表页评分统计图
    Route::any('reviewinfostar','MonitorProduct\ProductController@reviewInfoStar');
    //计算利润率
    Route::any('calculate','MonitorProduct\ProductController@calculate');
    //查询利润率
    Route::any('calculatelist','MonitorProduct\ProductController@calculateList');
    //listing标签占评论比例
    Route::any('tagdetail','MonitorProduct\ProductController@tagDetail');
});

//bsr分类监控
Route::group( [ 'prefix' => 'bsr' , 'middleware' => 'jwt.auth' ] , function( ){
    //添加我的bsr分类监控
    Route::any('bsradd','MonitorBsrCategory\BsrController@bsrAdd');
    //用户监控的bsr分类首页
    Route::any('bsrlist','MonitorBsrCategory\BsrController@bsrlist');
    //监控bsr详情页
    Route::any('bsrdetail','MonitorBsrCategory\BsrController@bsrDetail');
});

//keyword监控
Route::group( [ 'prefix' => 'keyword' , 'middleware' => 'jwt.auth' ] , function( ){
    //添加我的keyword监控
    Route::any('keywordadd','MonitorKeyword\KeywordController@keywordAdd');
    //用户监控的keyword首页
    Route::any('keywordlist','MonitorKeyword\KeywordController@keywordList');
    //用户监控keyword详情页
    Route::any('keyworddetail','MonitorKeyword\KeywordController@keywordDetail');
});