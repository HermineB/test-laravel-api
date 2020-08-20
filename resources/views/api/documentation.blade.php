@extends('layout')

@section('content')
    <div class="content">
        <div class="container mt-5">
            <p>API host <b> http://hh-back.ru/</b></p>

            <div class="card">
                <div class="card-header">
                    <h4>Реализовать CRUD контроллер</h4>
                </div>
                <div class="card-body">
                    <ul>
                        <li>
                            <div>POST <b> /api/products/add </b> - Метод создания товара</div>
                            <ul>
                                <li>name => required  |  string  |  max:200</li>
                                <li>description => string  |  max:1000</li>
                                <li>price => required  |  numeric</li>
                                <li>quantity => required  |  integer</li>
                                <li>categories => required  |  json</li>
                                <li>external_id => required</li>
                            </ul>
                        </li>
                        <li>
                            <div>POST <b> /api/products/update </b> - Метод редактирования товара</div>
                            <ul>
                                <li>string | max:200</li>
                                <li>string | max:1000</li>
                                <li>numeric</li>
                                <li>integer</li>
                                <li>json</li>
                                <li>required | unique:products</li>
                            </ul>
                        </li>
                        <li>
                            <div>POST <b> /api/products/get </b> - Метод получения списка товаров</div>
                            <ul>
                                <li>page => integer</li>
                                <li>
                                    <div>sort => {column},{sort_type}</div>
                                    <div><i class="text-info">column -> [price, created_at]</i></div>
                                    <div><i class="text-info">sort_type -> [asc, desc]</i></div>
                                    <div>for example -> <b>?sort=price,asc</b></div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div>GET <b> /api/products/get </b> - показывает только элементы на первой странице</div>
                        </li>
                        <li>
                            <div>POST <b> /api/products/getByCategory </b> - Метод получение списка товаров в конкретной
                                категории
                            </div>
                            <ul>
                                <li>category => required  |  integer</li>
                                <li>page => integer</li>
                                <li>
                                    <div>sort => {column},{sort_type}</div>
                                    <div><i class="text-info">column -> [price, created_at]</i></div>
                                    <div><i class="text-info">sort_type -> [asc, desc]</i></div>
                                    <div>for example -> <b>?sort=price,asc</b></div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div>POST <b> /api/products/getById </b> - Метод получения конкретного товара</div>
                            <ul>
                                <li>id => required  |  integer</li>
                            </ul>
                        </li>
                        <li>
                            <div>POST <b> /api/products/delete </b> - Метод удаления товара</div>
                            <ul>
                                <li>external_id => required  |  integer</li>
                            </ul>
                        </li>
                        <li>
                            <div>GET <b> /api/categories/get </b> - Метод получения списка всех категорий</div>
                        </li>
                        <li>
                            <div>POST <b> /api/categories/add </b> - Метод добавления категорий </div>
                            <ul>
                                <li> name => required,string,unique:categories,max:200</li>
                                <li> parent_id => integer</li>
                                <li> external_id => required,unique:categories,integer</li>
                            </ul>
                        </li>
                        <li>
                            <div>POST <b> /api/categories/update </b> - Метод редактирования категорий</div>
                            <ul>
                                <li>name => string,unique:categories ,max:200,</li>
                                <li>parent_id => integer,</li>
                                <li>external_id => required,integer,</li>
                            </ul>
                        </li>
                        <li>
                            <div>POST <b> /api/categories/delete </b> - Метод удаление категорий</div>
                            <ul>
                                <li>external_id => required,integer</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Реализовать консольную команду, которая читает два нижеприведенных файла JSON и добавляет/обновляет записи в БД, учесть валидацию данных.</h4>
                </div>
                <div class="card-body">
                    <ul>
                        <li>
                            php artisan read:products
                        </li>
                        <li>
                           php artisan read:categories
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
