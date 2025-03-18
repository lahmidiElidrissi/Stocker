<html>
<head>
  <style>
    @page { margin: 50px  19px 0px 19px; }
    header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; }
    footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; }
    #customers {
        border-collapse: collapse;
        width: 100%;
        }

        #customers td, #customers th {
        border: 1px solid #FF7676;
        padding: 8px;
        }


        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        color: black;
        }
        .page_break { page-break-before: always; }
  </style>
</head>
<body>
  <header>
   <center>
            <h1 style="color: rgba(9,9,119,1);">
                Electro Fizazi
            </h1>
        </center>
        <table style="width: 100%;">
            <tr>
                <td style="width: 45%;">
                    <center>
                    <h2>Bon De Livraison</h2>
                    <h2 style="color:red;border:red solid 1px;padding: 10px;width: fit-content;">
                        Bon De Conseignation N:{{$Commande->id}}
                    </h2>
                    </center>
                </td>
                <td style="width: 10%;">
                    &nbsp;
                </td>
                <td style="width: 45%;">
                    <h4>Date :  {{ date('d-m-Y', strtotime($Commande->dateCommnde));}}</h4> 
                    <div style="width: 100%;border: solid 1px #FF7676;">
                        <div style="padding-left: 10px;">
                        <h4> {{$client->Nom}} <br> {{$client->Societe}} <br> {{$client->Telephone}} </h4>
                        </div> 
                    </div>    
                </td>
            </tr>
        </table>
  </header>


<main>
        @for ($i = 0 ; $i < $pages; $i++)
                    <p style="color:white;">{{ $Total = 0 }}</p>
                    <center style="margin-top:175px;">
                        <table style="width: 100%;" id="customers">
                            <thead>
                                <th>
                                    Désgination
                                </th>
                                <th>
                                    Quentité
                                </th>
                                <th>
                                    Prix
                                </th>
                                <th style="text-align:right;">
                                    Montent
                                </th>
                            </thead>
                            <tbody>
                                {{ $CountTotal = 0 }}
                                @foreach($CommandeArticle->skip($moveing)->take(19) as $CommandeArticleSingle)
                                <tr>
                                    <td>
                                        {{$CommandeArticleSingle->article_id}}
                                    </td>
                                    <td>
                                        {{$CommandeArticleSingle->Quantite}}
                                    </td>
                                    <td>
                                        {{$CommandeArticleSingle->CustomPrix}} DH
                                    </td>
                                    <td style="text-align:right;">
                                        {{$CountTotal = $CommandeArticleSingle->Quantite * $CommandeArticleSingle->CustomPrix}} DH
                                    </td>
                                    {{$Total = $Total + $CountTotal}}
                                    @endforeach
                                            @if(19 - count($CommandeArticle->skip($moveing)->take(19)) != 0)
                                            @php
                                                $totalColom = 19 - count($CommandeArticle->skip($moveing)->take(19));
                                            @endphp
                                            @for ($j = 0 ; $j < $totalColom ; $j++)
                                            <tr style="border: #FF7676 solid;border-width: 0px 1px 0px 1px;color:white;">
                                            <td style="border: #FF7676 solid;border-width: 0px 1px 0px 1px;color:white;">
                                                nbsp;
                                            </td>
                                            <td style="border: #FF7676 solid;border-width: 0px 1px 0px 1px;color:white;">
                                                nbsp;
                                            </td>
                                            <td style="border: #FF7676 solid;border-width: 0px 1px 0px 1px;color:white;">
                                                nbsp;
                                            </td>
                                            <td style="border: #FF7676 solid;border-width: 0px 1px 0px 1px;color:white;">
                                                nbsp;
                                            </td>
                                            </tr>
                                            @endfor  
                                            @endif
                                </tr>
                                <tr style="border: #FF7676 solid;border-width: 1px 0px 0px 0px;">
                                <td style="border: #FF7676 solid;border-width: 1px 0px 0px 0px;color:white;">
                                    &nbsp;
                                </td>
                                <td style="border: #FF7676 solid;border-width: 1px 0px 0px 0px;color:white;">
                                    &nbsp;
                                </td>
                                <td style="border: #FF7676 solid;border-width: 1px 0px 0px 0px;color:white;">
                                    &nbsp;
                                </td>
                                <td style="border: 1px #FF7676 solid;text-align:right;">
                                   <b> <span style="margin-left: 10px;"> Total :  </span> 
                                    <span>{{$Total}} DH</span></b>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        
                    </center>
                    <p style="color:white;">{{$moveing = $moveing + 19}}</p>
            @endfor
</main>
</body>
</html>