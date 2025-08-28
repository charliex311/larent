<!-- © 2018 Shift Technologies. All rights reserved. -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#f9f9f9" id="bodyTable">
  <tbody>
    <tr>
      <td style="padding-right:10px;padding-left:10px;" align="center" valign="top" id="bodyCell">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperBody" style="max-width:600px">
          <tbody>
            <tr>
              <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard" style="background-color:#fff;">
                  <tbody>
                    <tr>
                      <td style="background-color:#00d2f4;font-size:1px;line-height:3px" class="topBorder" height="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="padding-top: 60px; padding-bottom: 20px;" align="center" valign="middle" class="emailLogo">
                        <a href="#" style="text-decoration:none" target="_blank">
                          <img alt="" border="0" src="" style="width:100%;max-width:150px;height:auto;display:block" width="150">
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="mainTitle">
                        <h2 class="text" style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:28px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:36px;text-transform:none;text-align:center;padding:0;margin:0">Hi {{$mailinfo['full_name']}}</h2>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding-left:20px;padding-right:20px" align="center" valign="top" class="containtTable ui-sortable">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription" style="">
                          <tbody>
                            <tr>
                              <td style="padding-bottom: 20px;" align="center" valign="top" class="description">
                                <h4 class="text" style="color:#666;font-family:'Open Sans',Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">{{$mailinfo['body']}}</h4>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButton" style="">
                          <tbody>
                            <tr>
                              <td style="padding-top:20px;padding-bottom:20px" align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" align="center">
                                  <tbody>
                                    <tr>
                                      <td style="background-color: rgb(0, 210, 244); padding: 12px 35px; border-radius: 50px;" align="center" class="ctaButton"> 
                                        <a href="#" style="color:#fff;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:13px;font-weight:600;font-style:normal;letter-spacing:1px;line-height:20px;text-transform:uppercase;text-decoration:none;display:block" target="_blank" class="text">Confirm Email</a>
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
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
                  <tbody>
                    <tr>
                      <td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperFooter" style="max-width:600px">
          <tbody>
            <tr>
              <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
                  <tbody>
                    <tr>
                      <td style="padding: 10px 10px 5px;" align="center" valign="top" class="brandInfo">
                        <p class="text" style="color:#bbb;font-family:'Open Sans',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:20px;text-transform:none;text-align:center;padding:0;margin:0">©&nbsp; {{config('app.name')}}.</p>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>