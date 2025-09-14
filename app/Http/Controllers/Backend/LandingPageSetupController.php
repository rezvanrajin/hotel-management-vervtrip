<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LandingPageSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    // landing page setup
    public function general_landing_page(){
        $setup_section_keywords = ['hero-section', 'research-keywords-section', 'steps-apply-section', 'about-section', 
        'choose-research-section', 'seminar-section', 'gallary-section', 'feeds-section', 'footer-section'];
        return view('backend.pages.setting.landing-page.general-page', compact('setup_section_keywords'));
    }

    public function hero_setup_section(Request $request)
    {
        $keyword = $request->get('keyword');
        if($keyword !== null){
            if($keyword == 'hero-section'){
                $html = View::make('backend.pages.setting.landing-page.hero-section')->render();
                return response()->json(['data' => $html, 'keyword' => $keyword]);
            }if($keyword == 'research-keywords-section'){
                $html = View::make('backend.pages.setting.landing-page.hero-section')->render();
                return response()->json(['data' => $html, 'keyword' => $keyword]);
            }
            
        }
      
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
