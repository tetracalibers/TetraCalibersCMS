<?php
use Illuminate\Support\Facades\Route;

Route::get('/sitemap', 'SitemapController@index')->name('sitemap');

Route::post('/confirm', 'ContactController@confirm')->name('contact.confirm');
Route::post('/thanks', 'ContactController@send')->name('contact.send');

Route::get('/', 'TopController');
Route::get('/profile', 'ProfileController');
Route::get('/clearnotes/{subject}', 'SubjectController@show');
Route::get('/latexbook/{latexbook}', 'LaTeXbookController@show');
Route::resource('blog', 'BlogController')->only(['index', 'show']);
Route::resource('tags', 'TagController')->only(['show']);
