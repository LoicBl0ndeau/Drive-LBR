<?php

function sendmail( string $Email, string $mail)
{

  $destinataire = $Email;
  // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
  $expediteur = 'contact@drivelbr.local';
  //$copie = 'contact@drivelbr.local';
  $copie_cachee = 'contact@drivelbr.local';
  $objet = 'Compte Drive LBR'; // Objet du message
  $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
  $headers .= 'Content-type: text/html; charset=utf-8'."\n"; // l'en-tete Content-type pour le format HTML
  $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
  $headers .= 'From: "Nom_de_expediteur"<'.$expediteur.'>'."\n"; // Expediteur
  $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
  //$headers .= 'Cc: '.$copie."\n"; // Copie Cc
  $headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc
  $message =  <<<MAIL
              <html>
                <head>
                  <title>Un titre ici</title>
                </head>
                <body>
                  <div>
                    <u></u>
                    <div style="margin:0px;padding:0px" bgcolor="#f6f6f6">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f6f6f6">
                        <tbody>
                          <tr>
                            <td align="center" valign="top">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f6f6f6">
                                <tbody>
                                  <tr>
                                    <td valign="top">
                                      <table align="center" width="635" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="background-color:#ffffff;width:635px;table-layout:fixed">
                                        <tbody>
                                          <tr>
                                            <td valign="top" align="center">
                                              <table width="553" border="0" cellspacing="0" cellpadding="0" style="width:553px;table-layout:fixed">
                                                <tbody>
                                                  <tr>
                                                    <td valign="middle" style="padding-bottom:15px">
                                                      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;table-layout:fixed">
                                                        <tbody>
                                                          <tr>
                                                            <td>
                                                              <table align="left" width="130" border="0" cellspacing="0" cellpadding="0" style="width:130px;table-layout:fixed">
                                                                <tbody>
                                                                  <tr>
                                                                    <td valign="top" align="left" style="font-size:15px;line-height:18px;font-family:'open-sans',sans-serif;color:#000000;font-weight:bold;padding-top:15px">
                                                                      <table align="left" width="130" border="0" cellspacing="0" cellpadding="0" style="width:130px;table-layout:fixed">
                                                                        <tbody>
                                                                          <tr>
                                                                            <td valign="top">
                                                                              <a href="https://www.lesbriquesrouges.fr/" style="display:block;text-decoration:none;color:#000000;font-weight:bold" target="_blank">
                                                                                <img width="130" alt="LBR" src="https://reflexhypnose.fr/images/logo_lbr.png" border="0" style="display:block;font-size:16px;font-family:Arial,sans-serif;color:#000000;max-width:130px;font-weight:bold" />
                                                                              </a>
                                                                            </td>
                                                                          </tr>
                                                                        </tbody>
                                                                      </table>
                                                                    </td>
                                                                  </tr>
                                                                </tbody>
                                                              </table>
                                                            </td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td valign="top" style="padding-bottom:15px">
                                                      <table align="center" width="553" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="background-color:#ffffff;width:553px;table-layout:fixed">
                                                        <tbody>
                                                          <tr>
                                                            <td height="1" style="line-height:1px;height:1px;background-color:#ececec">
                                                              <img height="1" width="553" style="height:1px;max-height:1px;min-height:1px;display:block;width:553px" border="0"/>
                                                            </td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td valign="top">
                                      <table align="center" width="635" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="background-color:#ffffff;width:635px;table-layout:fixed">
                                        <tbody>
                                          <tr>
                                            <td valign="top" align="center">
                                              <table width="553" border="0" cellspacing="0" cellpadding="0" style="width:553px;table-layout:fixed">
                                                <tbody>
                                                  <tr>
                                                    <td valign="top" style="text-align:center;font-size:20px;line-height:26px;font-family:'open-sans',sans-serif;color:#000000;padding-top:20px;padding-bottom:10px">
                                                      Informations sur votre compte<br />
                                                      Drive des Briques Rouges
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td valign="top">
                                      <table align="center" width="635" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="background-color:#ffffff;width:635px;table-layout:fixed">
                                        <tbody>
                                          <tr>
                                            <td valign="top" align="center">
                                              <table width="553" border="0" cellspacing="0" cellpadding="0" style="width:553px;table-layout:fixed">
                                                <tbody>
                                                  <tr>
                                                    <td valign="top" style="padding-top:30px;padding-bottom:30px">
                                                      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;table-layout:fixed">
                                                        <tbody>
                                                          <tr>
                                                            <td valign="top" style="text-align:justify;font-size:15px;line-height:18px;font-family:'open-sans',sans-serif;color:#000000">
                                                              $mail
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td valign="top" style="text-align:right;font-size:15px;line-height:18px;font-family:'open-sans',sans-serif;color:#000000;padding-top:30px;padding-bottom:10px">L’équipe Les Briques Rouges</td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td valign="top">
                                              <table align="center" width="635" border="0" cellspacing="0" cellpadding="0" bgcolor="#161920" style="background-color:#161920;width:635px;table-layout:fixed">
                                                <tbody>
                                                  <tr>
                                                    <td valign="top" align="center">
                                                      <table width="553" border="0" cellspacing="0" cellpadding="0" style="width:553px;table-layout:fixed">
                                                        <tbody>
                                                          <tr>
                                                            <td align="top">
                                                              <table align="left" width="275" border="0" cellspacing="0" cellpadding="0" style="width:275px;table-layout:fixed">
                                                                <tbody>
                                                                  <tr>
                                                                    <td valign="top" style="text-align:center;font-size:20px;line-height:22px;font-family:'open-sans',sans-serif;color:#fffee6;padding-top:25px;padding-bottom:5px">
                                                                      <strong>Suivez-nous :</strong>
                                                                    </td>
                                                                  </tr>
                                                                </tbody>
                                                              </table>
                                                              <table align="right" width="275" border="0" cellspacing="0" cellpadding="0" style="width:275px;table-layout:fixed">
                                                                <tbody>
                                                                  <tr>
                                                                    <td valign="top" style="text-align:center;font-size:16px;font-family:'open-sans',sans-serif;color:#fffee6;padding-top:20px">
                                                                      <table align="center" width="270" border="0" cellspacing="0" cellpadding="0" style="width:270px;table-layout:fixed">
                                                                        <tbody>
                                                                          <tr align="center" style="vertical-align:top;display:inline-block;text-align:center" valign="top">
                                                                            <td style="word-break:break-word;vertical-align:top;padding-right:10px;padding-left:10px" valign="top">
                                                                              <a href="https://www.instagram.com/lbr_festival/" target="_blank">
                                                                                <img alt="Instagram" height="32" src="https://www.lesbriquesrouges.fr/_nuxt/img/instagram.f57ba26.svg" style="text-decoration:none;height:auto;border:none;display:block" title="Facebook" width="32" />
                                                                              </a>
                                                                            </td>
                                                                            <td style="word-break:break-word;vertical-align:top;padding-right:10px;padding-left:10px" valign="top">
                                                                              <a href="https://www.linkedin.com/company/les-briques-rouges-festival" target="_blank">
                                                                                <img alt="Linkedin" height="32" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgeG1sbnM6dj0iaHR0cHM6Ly92ZWN0YS5pby9uYW5vIj48cGF0aCBmaWxsPSIjZmZmZWU2IiBkPSJNMTkgMEg1YTUgNSAwIDAgMC01IDV2MTRhNSA1IDAgMCAwIDUgNWgxNGE1IDUgMCAwIDAgNS01VjVhNSA1IDAgMCAwLTUtNXpNOCAxOUg1VjhoM3YxMXpNNi41IDYuNzMyYy0uOTY2IDAtMS43NS0uNzktMS43NS0xLjc2NHMuNzg0LTEuNzY0IDEuNzUtMS43NjQgMS43NS43OSAxLjc1IDEuNzY0LS43ODMgMS43NjQtMS43NSAxLjc2NHpNMjAgMTloLTN2LTUuNjA0YzAtMy4zNjgtNC0zLjExMy00IDBWMTloLTNWOGgzdjEuNzY1YzEuMzk2LTIuNTg2IDctMi43NzcgNyAyLjQ3NlYxOXoiLz48L3N2Zz4=" style="text-decoration:none;height:auto;border:none;display:block" title="Twitter" width="32" />
                                                                              </a>
                                                                            </td>
                                                                            <td style="word-break:break-word;vertical-align:top;padding-right:10px;padding-left:10px" valign="top">
                                                                              <a href="https://www.facebook.com/LBRfestival" target="_blank">
                                                                                <img alt="Facebook" height="32" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNSIgaGVpZ2h0PSIyNSIgZmlsbD0ibm9uZSIgeG1sbnM6dj0iaHR0cHM6Ly92ZWN0YS5pby9uYW5vIj48cGF0aCBkPSJNMTguMzE3IDE0LjA2M2wuNjk0LTQuNTI0SDE0LjY3VjYuNjAyYzAtMS4yMzguNjA2LTIuNDQ0IDIuNTUxLTIuNDQ0aDEuOTc0Vi4zMDZTMTcuNDA0IDAgMTUuNjkxIDBjLTMuNTc1IDAtNS45MTIgMi4xNjctNS45MTIgNi4wOXYzLjQ0OEg1LjgwNXY0LjUyNGgzLjk3NFYyNWg0Ljg5MVYxNC4wNjNoMy42NDd6IiBmaWxsPSIjZmZmZWU2Ii8+PC9zdmc+" style="text-decoration:none;height:auto;border:none;display:block" title="YouTube" width="32" />
                                                                              </a>
                                                                            </td>
                                                                            <td style="word-break:break-word;vertical-align:top;padding-right:10px;padding-left:10px" valign="top">
                                                                              <a href="https://www.youtube.com/channel/UCf9g0UfCsETQilcTj0ljzlA/featured" target="_blank">
                                                                                <img alt="Youtube" height="32" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZwAAAGcAQMAAADXj4R6AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAGUExURUdwTP/+5uLkO8IAAAABdFJOUwBA5thmAAACuElEQVR42u3bsXHjMBCFYWAQIGQJKAWlgRddGS7FLEUlKGSgIS44y7Yky8T7fbPDudnNvxG5C5IAhA3Bw8PDw8PDw8PDw8NjLFLfi8uDiX0/1ntUBlCf9R96+KlpCPVbVMfQol/d3fXlQbTJubvPXxtFJ/2Wbm4qDaOLXKXbStVxNOt5+JyJcdPPeh4+pS8LaAPJ+0hfUdCsZ/zj6WgKOukZf895lNCql+l9yGYJbaBM10IVDc16ma6FagbopNf2rbpRRKteW4gu+oB4GxKTBepgFP0dRwhVFS0UNRWdKFJNP0MUZbRClGR0sURZRpslkp/B3i1R0dF8dFR1tPyXqBmhkyNHjg6IXgl6Ieg3Qb8ImhGqBE0EZYIiQTvD5AkqBE0EJYICQo2gQlAmKBIUEKoETQRlgiJB35X3OaoETQQlggJCjaBCUCYoERQQqgRNBGWCIkFPy/stqgRNBCWCAkKNoEJQJigRFBCqBBWCMkGRoK/Lu4cqQRNBiaBI0JeZ2EWFoExQIiggVM2QWSKyWXGb1YBNZg9htXqxRLOXZTH7AJh91NDnE32o0ZTAbJqDJlRo6kYmiWg6iia+aIqNJvNmCxS0FEKLLrS8M1uyosUxWoaTBT/aWkCbGGi7BG3MmG02oW0ttIGGturMth/RRifaUm0AoW1itCGNtr4rQR0g9McB+ovihaBXgrojR46OjqqOFkdXVHR0+PNGBz/idfADcnYnBe2OTCJkd3bU8Dxs1V8REBX9wYUnpBFCp74RQofS0Zl5hNCRftY8UPVRBLsoEEJNHqidBDWuoBYZ1IzD2n6qXlvYyoQ6rZKecS3n649azpT0LQF0gs1Bb1TbftgaGEAehEwsAXQhai2zj7c0fFPnABo/56Bf331bb1OeWmVQbA/9w1UrkoeHh4eHh4eHh4eHxz+PP9vG7iWZrG4uAAAAAElFTkSuQmCC" style="text-decoration:none;height:auto;border:none;display:block" title="Instagram" width="32" />
                                                                              </a>
                                                                            </td>
                                                                          </tr>
                                                                        </tbody>
                                                                      </table>
                                                                    </td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td height="20" style="height:20px;font-size:0px;line-height:1px">&nbsp;</td>
                                                                  </tr>
                                                                </tbody>
                                                              </table>
                                                            </td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;table-layout:fixed">
                                                        <tbody>
                                                          <tr>
                                                            <td valign="top" style="padding-bottom:15px">
                                                              <table align="center" width="553" border="0" cellspacing="0" cellpadding="0" bgcolor="#161920" style="background-color:#161920;width:553px;table-layout:fixed">
                                                                <tbody>
                                                                  <tr>
                                                                    <td height="1" style="line-height:1px;height:1px;background-color:#ececec">
                                                                    </td>
                                                                  </tr>
                                                                </tbody>
                                                              </table>
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td valign="top">
                                                              <table align="center" width="553" border="0" cellspacing="0" cellpadding="0" bgcolor="#161920" style="background-color:#161920;width:553px;table-layout:fixed">
                                                                <tbody>
                                                                  <tr>
                                                                    <td align="top" style="font-size:10px;line-height:14px;font-family:'open-sans',sans-serif;color:#fffee6;font-weight:normal;text-align:justify;padding-bottom:15px">
                                                                      Pour plus d’informations concernant la gestion de vos données à caractère personnel, veuillez consulter la
                                                                      <a href="https://www.lesbriquesrouges.fr/politique-de-confidentialite" style="font-size:10px;line-height:14px;font-family:'open-sans',sans-serif;color:#fffee6;font-weight:normal;text-decoration:underline" target="_blank">Politique de confidentialité des données</a>.<br /><br />
                                                                      © 2022 Les Briques Rouges Festival | 13 rue de Toul, 59800 Lille
                                                                    </td>
                                                                  </tr>
                                                                </tbody>
                                                              </table>
                                                            </td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <div style="white-space:nowrap;display:none;font-size:0px;line-height:0px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div></div>
                    <div>
                    </div>
                  </div>
                </body>
              </html>
              MAIL;

  if (mail($destinataire, $objet, $message, $headers)) {
    //echo "Email envoyé avec succès à $destinataire ... <br><br><br>";

    include("connect.php");

    // Ecriture de la requête
    $sqlQuery = 'INSERT INTO log_(Nom, Date_de_modification, Description) VALUES (:Nom, :Date_de_modification, :Description)';

    // Préparation
    $edited_user = $PDO->prepare($sqlQuery);

    // Exécution ! l'utilisateur est maintenant en base de données
    $edited_user->execute([
        'Nom' => 'Boite mail',
        'Date_de_modification' => date('d-m-y H:i:s'),
        'Description' => "Envoi d'un mail à : $Email",
    ]);
  } else {
    echo '<script>alert("Échec de l\'envoi de l\'email...");document.location.href="login.php";</script>';
  }
}
?>
