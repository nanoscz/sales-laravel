@extends('main')
@section('content')
    @if(Auth::check())  
        @if(Auth::user()->id_rol == 1)
            <template v-if="menu==0">
            <h1> Desktop</h1>
            </template>
            <template v-if="menu==1">
                <category></category>
            </template>
            <template v-if="menu==2">
                <articles></articles>
            </template>
            <template v-if="menu==3">
                <h1>Ingreso</h1>
            </template>
            <template v-if="menu==4">
                <provider></provider>
            </template>
            <template v-if="menu==5">
                <h1>Ventas</h1>
            </template>
            <template v-if="menu==6">
                <client></client>
            </template>
            <template v-if="menu==7">
                <user></user>
            </template>
            <template v-if="menu==8">
                <rol></rol>
            </template>
            <template v-if="menu==9">
                <h1> reporte de ingreso</h1>
            </template>
            <template v-if="menu==10">
                <h1>reporte de ventas</h1>
            </template>
            <template v-if="menu==11">
                <h1> ayuda </h1>
            </template>
            <template v-if="menu==12">
                <h1>Acerca de..</h1>
            </template>
        @elseif(Auth::user()->id_rol == 2)
            <template v-if="menu==5">
                <h1>Ventas</h1>
            </template>
            <template v-if="menu==6">
                <client></client>
            </template>
            <template v-if="menu==10">
                <h1>reporte de ventas</h1>
            </template>
            <template v-if="menu==11">
                <h1> ayuda </h1>
            </template>
            <template v-if="menu==12">
                <h1>Acerca de..</h1>
            </template>
        @elseif(Auth::user()->id_rol == 3)
            <template v-if="menu==1">
                <category></category>
            </template>
            <template v-if="menu==2">
                <articles></articles>
            </template>
            <template v-if="menu==3">
                <h1>Ingreso</h1>
            </template>
            <template v-if="menu==4">
                <provider></provider>
            </template>
            <template v-if="menu==9">
                <h1> reporte de ingreso</h1>
            </template>
            <template v-if="menu==11">
                <h1> ayuda </h1>
            </template>
            <template v-if="menu==12">
                <h1>Acerca de..</h1>
            </template>
        @else
        
        @endif
    @endif
@endsection