@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="page-header">Terms of Service Agreements</h2>

        <div class="row">
            <div class="col-md-12 form-group">

                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control input-lg" id="searchInput" onkeyup="search()" placeholder="Search by name..." />
                        <span class="input-group-btn">
                        <button class="btn btn-search btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <span class="">Or by date:</span>

        <div class="row">
            <div class="col-md-6 form-group">
                <select id="month" name="month" class="form-control" onchange="searchByDate()">
                    <option value="" selected>Select a month...</option>
                    <option value="jan">January</option>
                    <option value="feb">Febraury</option>
                    <option value="mar">March</option>
                    <option value="apr">April</option>
                    <option value="may">May</option>
                    <option value="jun">June</option>
                    <option value="jul">July</option>
                    <option value="aug">August</option>
                    <option value="sep">September</option>
                    <option value="oct">October</option>
                    <option value="nov">November</option>
                    <option value="dec">December</option>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <select id="year" name="year" class="form-control" onchange="searchByDate()">
                    <option value="" selected>Select a year...</option>
                    {{ $currentYear = date('Y') }}
                    @foreach(range(2010, $currentYear) as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <span>Or by client:</span>
        <div class="row">
            <div class="btn-group btn-group-justified col-md-12" role="group">
                <a href="#" class="btn btn-primary" role="button" onclick="showSelectedClient('autonation')">Autonation</a>
                <a href="#" class="btn btn-primary" role="button" onclick="showSelectedClient('mcnutt')">McNutt</a>
                <a href="#" class="btn btn-primary" role="button" onclick="showSelectedClient('metrogistics')">Metrogistics</a>
                <a href="#" class="btn btn-primary" role="button" onclick="showSelectedClient('sonic')">Sonic</a>
            </div>
        </div>

        <hr>

        <ul id="agreementUL">
            @foreach($keys as $key)
                <li>
                    <form action="/TOS" method="post">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-link" name="key" value="{{ $key }}">
                    </form>
                </li>
            @endforeach
        </ul>

    </div>

@endsection

@section('js')

    <script>

        function search() {

            // Declare variables
            var input = document.getElementById('searchInput').value.toUpperCase();
            var ul = document.getElementById("agreementUL");
            var li = ul.getElementsByTagName('li');
            var regex = new RegExp(input);

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                console.log(li[i].innerHTML.toUpperCase().search(regex));
                if (li[i].innerHTML.toUpperCase().search(regex) == -1) {
                    li[i].style.display = "none";
                } else {
                    li[i].style.display = "";
                }
            }
        }

        function searchByDate(){

            // Declare variables
            var month = document.getElementById('month').value.toUpperCase();
            var year = document.getElementById('year').value;
            var ul = document.getElementById("agreementUL");
            var li = ul.getElementsByTagName('li');
            var dateRegexString = null;
            var regex = null;

            if (month == "" && year == ""){
                return;
            }
            else if (month != "" && year != ""){
                dateRegexString = "\\d{2}" + month + year + "\\d{6}";
            }
            else if (month != "" && year == ""){
                dateRegexString = "\\d{2}" + month;
            }
            else if (month == "" & year != ""){
                dateRegexString = year + "\\d{6}";
            }

            regex = new RegExp(dateRegexString);

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                if (li[i].innerHTML.toUpperCase().search(regex) == -1) {
                    li[i].style.display = "none";
                } else {
                    li[i].style.display = "";
                }
            }
        }

        function showSelectedClient(client){

            // Declare variables
            var ul = document.getElementById("agreementUL");
            var li = ul.getElementsByTagName('li');
            var regex = new RegExp(client);

            // loop through list items and hide items that do not match
            for (i=0; i<li.length; i++){
                if (li[i].innerHTML.search(regex) == -1){
                    li[i].style.display = "none";
                } else {
                    li[i].style.display = "";
                }
            }
        }

    </script>

@endsection