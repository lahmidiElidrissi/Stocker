<!DOCTYPE html>
<html lang="en">
<head>
    <title>Facture</title>
</head>
<body>
    <style>
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
    </style>
    <div>
        
        <center>
            <h1 style="color: rgba(9,9,121,1);">
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
        <center>
            <table style="width: 100%; margin-top: 20px; height: 70%;" id="customers">
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
                    @foreach($CommandeArticle as $CommandeArticleSingle)
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
                            {{$CommandeArticleSingle->Quantite * $CommandeArticleSingle->CustomPrix}} DH
                        </td>
                        @endforeach
                    </tr>
                    <tr style="border: 0px #FF7676 solid;">
                        <td style="border: 0px #FF7676 solid;">
                            &nbsp;
                        </td>
                        <td style="border: 0px #FF7676 solid;">
                            &nbsp;
                        </td>
                        <td style="border: 0px #FF7676 solid;">
                            &nbsp;
                        </td>
                        <td style="border: 1px #FF7676 solid;">
                            <H3 ><span style="margin-left: 10px;text-align: left!important;"> Total :  </span> 
                            <span style="text-align: right;">{{$Commande->total}} DH</span>
                            </H3>
                        </td>
                    </tr>
          </tbody>
        </table>
        </center>
        {{$pages}}
    </div>

    
</body>
</html>