<div class="row" id="foote">
    @if($row && $profile_row)
    <div class="contentBox p-2">
        <p class="logo-color">{{ $company_name }}</p>
        <p class="logo-color">Postanschrift</p>
        <p>{{ $street }}</p>
        <p>{{ $postal_code }} {{ $city }} {{ $country }}</p>
    </div>
    <div class="contentBox p-2">
        <p class="logo-color">Mobil</p>
        <p><a href="tel:{{$mobile}}">{{ $mobile }}</a></p>
        <p class="logo-color">E-Mail</p>
        <p><a href="mailto:{{$email}}">{{ $email }}</a></p>
    </div>

    <div class="contentBox p-2">
        <p class="logo-color">Webseite</p>
        <p><a target="_blank" href="{{$website}}">{{$website}}</a></p>
        <p class="logo-color">Steuernummer</p>
        <p>{{$tax_number}}</p>
    </div>
    <div class="contentBox p-2">
        <p class="logo-color">USt-IdNr</p>
        <p>{{$ust_idnr}}</p>
        <p class="logo-color">Betriebsnummer</p>
        <p>{{$business_number}}</p>
    </div>
    <div class="contentBox p-2">
        <p class="logo-color">Bankverbindung</p>
        <p class="mt-2">{{$bank}}<br>{{$bic}}<br></p>
        <p class="vsmalltext">{{$iban}}</p>
    </div>
    @endif
</div>