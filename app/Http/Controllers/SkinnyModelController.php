<?php

namespace App\Http\Controllers;

use App\Builder\SkinnyModelDirector;
use App\Decorators\SkinnyModelDecorator;
use App\Factories\SkinnyModelFactory;
use App\Repositories\SkinnyModelRepository;
use App\SkinnyModel;
use Illuminate\Http\Request;

class SkinnyModelController extends Controller
{
    /**
     * @var SkinnyModelFactory
     */
    private $skinnyModelFactory;
    /**
     * @var SkinnyModelDirector
     */
    private $skinnyModelDirector;
    /**
     * @var SkinnyModelRepository
     */
    private $skinnyModelRepository;

    public function __construct(
        SkinnyModelFactory $skinnyModelFactory,
        SkinnyModelDirector $skinnyModelDirector,
        SkinnyModelRepository $skinnyModelRepository
    ) {
        $this->skinnyModelFactory = $skinnyModelFactory;
        $this->skinnyModelDirector = $skinnyModelDirector;
        $this->skinnyModelRepository = $skinnyModelRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skinnyModels = $this->skinnyModelRepository
            ->active()
            ->withDescription()
            ->whereWeightBetween(1, 100)
            ->whereFirstNameLike('a')
            ->get();

        return view('skinny-model-index', compact('skinnyModels'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $skinnyModel = $this->skinnyModelFactory
            ->pushDirector($this->skinnyModelDirector)
            ->make($request->all());
        $skinnyModel->save();

        $skinnyModelDecorator = new SkinnyModelDecorator($skinnyModel);
        return view('skinny-model-store', compact('skinnyModelDecorator'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SkinnyModel $skinnyModel
     * @return \Illuminate\Http\Response
     */
    public function show(SkinnyModel $skinnyModel)
    {
        $skinnyModelDecorator = new SkinnyModelDecorator($skinnyModel);

        return view('skinny-model-show', compact('skinnyModelDecorator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SkinnyModel $skinnyModel
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SkinnyModel $skinnyModel)
    {
        $this->skinnyModelFactory
            ->pushDirector($this->skinnyModelDirector)
            ->make($request->all(), $skinnyModel);
        $skinnyModel->save();

        $skinnyModelDecorator = new SkinnyModelDecorator($skinnyModel);
        return view('skinny-model-edit', compact('skinnyModelDecorator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\SkinnyModel $skinnyModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SkinnyModel $skinnyModel)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SkinnyModel $skinnyModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(SkinnyModel $skinnyModel)
    {
        //
    }
}
