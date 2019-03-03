@extends('main')
@section('content')
    <template v-if="menu==0">
        <h1> el menu seleccionado es 0</h1>
    </template>
    <template v-if="menu==1">
        <category></category>
    </template>
    <template v-if="menu==2">
        <articles></articles>
    </template>
    <template v-if="menu==3">
        <h1> el menu seleccionado es 1</h1>
    </template>
    <template v-if="menu==4">
        <h1>el menu seleccionado es 2</h1>
    </template>
    <template v-if="menu==5">
        <h1> el menu seleccionado es 1</h1>
    </template>
    <template v-if="menu==6">
        <client></client>
    </template>
    <template v-if="menu==7">
        <h1> el menu seleccionado es 1</h1>
    </template>
    <template v-if="menu==8">
        <h1>el menu seleccionado es 2</h1>
    </template>
    <template v-if="menu==9">
        <h1> el menu seleccionado es 1</h1>
    </template>
    <template v-if="menu==10">
        <h1>el menu seleccionado es 2</h1>
    </template>
    <template v-if="menu==11">
        <h1> el menu seleccionado es 1</h1>
    </template>
    <template v-if="menu==12">
        <h1>el menu seleccionado es 2</h1>
    </template>
@endsection