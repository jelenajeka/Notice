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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/types', 'NoticeController@types')->name('types');
Route::get('/types/view/create', 'NoticeController@viewAddType')->name('viewAddType');
Route::post('/types/create', 'NoticeController@addType')->name('addType');
Route::get('/types/{id}', 'NoticeController@viewType')->name('viewType');
Route::put('/types/{id}', 'NoticeController@editType')->name('editType');
Route::delete('/types/{id}', 'NoticeController@deleteType')->name('deleteType');

Route::get('/notices', 'NoticeController@viewNotices')->name('viewNotices');
Route::get('/notices/view/create', 'NoticeController@viewAddNotice')->name('viewAddNotice');
Route::post('/notices/create', 'NoticeController@addNotice')->name('addNotice');
Route::get('/notices/{id}', 'NoticeController@viewNotice')->name('viewNotice');
Route::get('/notices/{id}/edit', 'NoticeController@viewEditNotice')->name('viewEditNotice');
Route::put('/notices/{id}', 'NoticeController@editNotice')->name('editNotice');
Route::delete('/notices/{id}', 'NoticeController@deleteNotice')->name('deleteNotice');

Route::get('/notices/views/search', 'NoticeController@searchNotice')->name('searchNotice');
Route::post('/notices/views/notices_group','NoticeController@noticesGroup')->name('noticesGroup');
Route::any('/notices/views/text_formated', 'NoticeController@textFormated')->name('textFormated');
Route::any('/notices/views/upload_form_img', 'NoticeController@uploadFormImg')->name('uploadFormImg');
Route::any('/notices/views/not_save_image', 'NoticeController@notSaveImage')->name('notSaveImage');
Route::any('/notices/views/upload_form_file', 'NoticeController@uploadFormFile')->name('uploadFormFile');
Route::any('/notices/views/not_save_file', 'NoticeController@notSaveFile')->name('notSaveFile');
