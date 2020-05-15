@extends('master')

@section('title', $tournament->name)

@section('content')

<h1> {{ $tournament->name }}</h1>

	<ul class="nav nav-tabs nav-fill mt-3" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="tabela-tab" data-toggle="tab" href="#tabela" role="tab"
				aria-controls="tabela" aria-selected="true">Tabela</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="rezultati-id" data-toggle="tab" href="#rezultati" role="tab"
				aria-controls="rezultati" aria-selected="false">Rezultati</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="spisak-tab" data-toggle="tab" href="#spisak" role="tab" aria-controls="spisak"
				aria-selected="false">Informacije</a>
		</li>
	</ul>
	
	<div class="tab-content" id="myTabContent">

		<!-- Tabela TAB -->
		<div class="tab-pane fade show active p-5" id="tabela" role="tabpanel" aria-labelledby="tabela-tab">
			<div class="container-fluid mt-1 ml-5">
				<h1 class="h1">Tabela</h1>
				<table class="table table-hover w-75 text-center">
					<thead class="thead-dark">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Ime i prezime</th>
							<th scope="col">Poeni</th>
						</tr>
					</thead>

					<tbody>
						@foreach($tournament->participants as $participant)
						<tr>
							<th scope="row">1.</th>
							<td>{{ $participant->name }} @if($tournament->type='player') {{$participant->surname }} @endif</td>
							<td>0</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<!-- Rezultati tab -->
		<div class="tab-pane fade p-5" id="rezultati" role="tabpanel" aria-labelledby="rezultati-tab">
			<div class="container-fluid mt-1 ml-5">
				<h1 class="h1">Rezultati</h1>

				@auth('player')
				@if(Auth::guard('player')->user()->isArbiter() && $tournament->arbiters->contains('id', Auth::user()->id))
				<a href="/turnir/{{$tournament->id}}/dodajRezultat" class="btn btn-primary mb-1">Dodavanje rezultata</a>
				@endif
				@endauth

				@for($i = 1; $i <= $rounds; $i++)
				<h3 class="h3">{{$i}}. Kolo</h3>
				<table class="table table-hover w-75 text-center">
					<thead class="thead-dark">
						<tr>
							<th scope="col">#</th>
							<th class="w-30" scope="col">Beli</th>
							<th scope="col">Poeni</th>
							<th scope="col">Rezultat</th>
							<th class="w-30" scope="col">Crni</th>
							<th scope="col">Poeni</th>
						</tr>
					</thead>

					<tbody>
						@php
						$results = App\Result::where('tournament_id', $tournament->id)->where('round', $i)->orderBy('table')->get();
						@endphp

						@foreach($results as $result)
						<tr>
							<th scope="row">{{$loop->index + 1}}.</th>
							<td class="w-30">{{$result->white()->name}} {{$result->white()->surname}}</td>
							<td>7</td>
							<td>{{$result->result}}</td>
							<td class="w-30">{{$result->black()->name}} {{$result->black()->surname}}</td>
							<td>3</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@endfor
				
			</div>
		</div>

		<!-- Informacije tab-->
		<div class="tab-pane fade p-5" id="spisak" role="tabpanel" aria-labelledby="spisak-tab">
			<div class="container-fluid mt-1 ml-5">
				<h1 class="h1">Informacije</h1>
				

				<p class="p">Datum pocetka: {{date('d.m.Y.', strtotime($tournament->start_date))}}</p>
				<p class="p">Datum kraja: {{date('d.m.Y.', strtotime($tournament->end_date))}}</p>
				<p class="p">Email: {{$tournament->email}}</p>
				<p class="p">Telefon: {{$tournament->phone}}</p>
				<p class="p">Adresa: {{$tournament->place}}</p>

				@auth('player')
					@if(Auth::guard('player')->user()->email == $tournament->email)
						<a href="/turnir/{{$tournament->id}}/sudije" class="btn btn-primary">Dodavanje sudija</a>
					@endif
				@endauth

				@auth('admin')
					@if(Auth::guard('admin')->user()->email == $tournament->email)
						<a href="/turnir/{{$tournament->id}}/sudije" class="btn btn-primary">Dodavanje sudija</a>
					@endif
				@endauth

				@auth('club')
					@if(Auth::guard('club')->user()->email == $tournament->email)
						<a href="/turnir/{{$tournament->id}}/sudije" class="btn btn-primary">Dodavanje sudija</a>
					@endif
				@endauth

				<table class="table table-hover text-center col-12">
					<thead class="thead-dark">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Sudija</th>
							<th scope="col">Rang</th>
							
							@auth('player')
								@if(Auth::guard('player')->user()->email == $tournament->email)
									<th scope="col">Ukloni sudiju</th>
								@endif
							@endauth

							@auth('admin')
								@if(Auth::guard('admin')->user()->email == $tournament->email)
									<th scope="col">Ukloni sudiju</th>
								@endif
							@endauth

							@auth('club')
								@if(Auth::guard('club')->user()->email == $tournament->email)
									<th scope="col">Ukloni sudiju</th>
								@endif
							@endauth

						</tr>
					</thead>

					<tbody>
						@foreach($tournament->arbiters as $arbiter)
						<tr>
							<th scope="row">{{$loop->index + 1}}</th>
							<td>{{ $arbiter->name }} {{$arbiter->surname }}</td>
							<td>{{ $arbiter->getArbiterRank() }}</td>
							<td>
								<form class="form-inline d-flex justify-content-center" method="POST" action="/turnir/{{$tournament->id}}/ukloniSudiju">
									@csrf
									<input type="hidden" name="arbiter_id" value="{{$arbiter->id}}">
									<input type="submit" class="btn btn-danger" value="-">
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection