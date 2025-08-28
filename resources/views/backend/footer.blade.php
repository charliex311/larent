<footer class="border-top border-2 border-400 py-1 mt-3 " style="position: absolute;bottom: auto;width: 100%;bottom: 0">
    <div class="row g-0 justify-content-between fs-0 mt-4 mb-3">
        <div class="col-12 col-sm-auto text-left">
            <p class="mb-0 text-600">
            {{ companyname() }} <br />
            Postanschrift <br />
            LÃ¶wenbergerstr 2 <br />
            {{companyAddress()}} <br />
            </p>
        </div>
        <div class="col-12 col-sm-auto text-left">
            <p class="mb-0 text-600">
            10315 Berlin Germany <br />
            <a href="tel:015757010977">015757010977</a><br />
            E-Mail <br />
            <a href="mailto:{{companyEmail()}}">{{companyEmail()}}</a> <br />
            </p>
        </div>
        <div class="col-12 col-sm-auto text-left">
            <p class="mb-0 text-600">
            Webseite <br />
            <a target="_blank" href="{{companyWebsite()}}">{{ preg_replace('/\.+/', '.', str_replace(['https://', 'http://', 'www'], 'www.', companyWebsite())) }}</a> <br />
            Steuernummer <br />
            132/571/00584 <br />
            </p>
        </div>
        <div class="col-12 col-sm-auto text-left">
            <p class="mb-0 text-600">
            USt-IdNr <br />
            DE301503988 <br />
            Betriebsnummer <br />
            969504433 <br />
            </p>
        </div>
        <div class="col-12 col-sm-auto text-left">
            <p class="mb-0 text-600">
            Bankverbindung <br />
            N26 <br />
            NTSBDEB1XXX <br />
            DE04100110012626447499 <br />
            </p>
        </div>
    </div>
</footer>