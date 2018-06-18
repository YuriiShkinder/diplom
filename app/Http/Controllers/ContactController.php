<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class ContactController extends SiteController
{
   public function __construct()
   {
       parent::__construct(new CategoryRepository(new Category()));
   }

    public function index()
    {
        $this->title='Контакты';
        $this->template='contact';
        return $this->renderOutput();
    }
    public function about()
    {
        $this->title='Про нас';
        $this->template='about';
        return $this->renderOutput();

    }
    public function delivery()
    {
        $this->title='Доставка и оплата';
        $this->template='delivery';
        return $this->renderOutput();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
