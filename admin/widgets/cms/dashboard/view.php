<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Home</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png"> Dashboard</h1>
    </div>
    <div class="content">
        <!-- <div class="overview">
            <div class="dashboard-heading">Overview</div>
            <div class="dashboard-content">
                <table>
                    <tbody><tr>
                            <td>Total Sales:</td>
                            <td>$0.00</td>
                        </tr>
                        <tr>
                            <td>Total Sales This Year:</td>
                            <td>$0.00</td>
                        </tr>
                        <tr>
                            <td>Total Orders:</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>No. of Customers:</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Customers Awaiting Approval:</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Reviews Awaiting Approval:</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>No. of Affiliates:</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Affiliates Awaiting Approval:</td>
                            <td>0</td>
                        </tr>
                    </tbody></table>
            </div>
        </div>
        <div class="statistic">
            <div class="range">Select Range:          <select onchange="getSalesChart(this.value)" id="range">
                    <option value="day">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>
                </select>
            </div>
            <div class="dashboard-heading">Statistics</div>
            <div class="dashboard-content">
                <div style="width: 390px; height: 170px; margin: auto; padding: 0px; position: relative;" id="report"><canvas class="base" width="390" height="170"></canvas><canvas class="overlay" width="390" height="170" style="position: absolute; left: 0px; top: 0px;"></canvas><div style="font-size:smaller" class="tickLabels"><div style="color:#545454" class="xAxis x1Axis"><div style="position:absolute;text-align:center;left:17px;top:157px;width:16px" class="tickLabel">00</div><div style="position:absolute;text-align:center;left:33px;top:157px;width:16px" class="tickLabel">01</div><div style="position:absolute;text-align:center;left:48px;top:157px;width:16px" class="tickLabel">02</div><div style="position:absolute;text-align:center;left:64px;top:157px;width:16px" class="tickLabel">03</div><div style="position:absolute;text-align:center;left:80px;top:157px;width:16px" class="tickLabel">04</div><div style="position:absolute;text-align:center;left:95px;top:157px;width:16px" class="tickLabel">05</div><div style="position:absolute;text-align:center;left:111px;top:157px;width:16px" class="tickLabel">06</div><div style="position:absolute;text-align:center;left:127px;top:157px;width:16px" class="tickLabel">07</div><div style="position:absolute;text-align:center;left:143px;top:157px;width:16px" class="tickLabel">08</div><div style="position:absolute;text-align:center;left:158px;top:157px;width:16px" class="tickLabel">09</div><div style="position:absolute;text-align:center;left:174px;top:157px;width:16px" class="tickLabel">10</div><div style="position:absolute;text-align:center;left:190px;top:157px;width:16px" class="tickLabel">11</div><div style="position:absolute;text-align:center;left:205px;top:157px;width:16px" class="tickLabel">12</div><div style="position:absolute;text-align:center;left:221px;top:157px;width:16px" class="tickLabel">13</div><div style="position:absolute;text-align:center;left:237px;top:157px;width:16px" class="tickLabel">14</div><div style="position:absolute;text-align:center;left:252px;top:157px;width:16px" class="tickLabel">15</div><div style="position:absolute;text-align:center;left:268px;top:157px;width:16px" class="tickLabel">16</div><div style="position:absolute;text-align:center;left:284px;top:157px;width:16px" class="tickLabel">17</div><div style="position:absolute;text-align:center;left:300px;top:157px;width:16px" class="tickLabel">18</div><div style="position:absolute;text-align:center;left:315px;top:157px;width:16px" class="tickLabel">19</div><div style="position:absolute;text-align:center;left:331px;top:157px;width:16px" class="tickLabel">20</div><div style="position:absolute;text-align:center;left:347px;top:157px;width:16px" class="tickLabel">21</div><div style="position:absolute;text-align:center;left:362px;top:157px;width:16px" class="tickLabel">22</div><div style="position:absolute;text-align:center;left:378px;top:157px;width:16px" class="tickLabel">23</div></div><div style="color:#545454" class="yAxis y1Axis"><div style="position:absolute;text-align:right;top:144px;right:372px;width:18px" class="tickLabel">-1.0</div><div style="position:absolute;text-align:right;top:107px;right:372px;width:18px" class="tickLabel">-0.5</div><div style="position:absolute;text-align:right;top:71px;right:372px;width:18px" class="tickLabel">0.0</div><div style="position:absolute;text-align:right;top:34px;right:372px;width:18px" class="tickLabel">0.5</div><div style="position:absolute;text-align:right;top:-2px;right:372px;width:18px" class="tickLabel">1.0</div></div></div><div class="legend"><div style="position: absolute; width: 119px; height: 40px; top: 9px; right: 9px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div><table style="position:absolute;top:9px;right:9px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(237,194,64);overflow:hidden"></div></div></td><td class="legendLabel">Total Orders</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(175,216,248);overflow:hidden"></div></div></td><td class="legendLabel">Total Customers</td></tr></tbody></table></div></div>
            </div>
        </div> -->
        <div class="latest">
            <div class="dashboard-heading">20 Đơn Hàng Mới Nhất Chưa Xử Lý</div>
            <div class="dashboard-content">
                <table class="list">
                    <thead>
                        <tr>
                            <td class="right">Order ID</td>
                            <td class="left">Khách Hàng</td>
                            <td class="left">Ngày Đặt</td>
                            <td class="right">Giá</td>
                            <td class="right">Tùy Chọn</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$order){ ?>
                        <tr>
                            <td colspan="6" class="center">No results!</td>
                        </tr>
                        <?php } else { ?>
                        <?php foreach ($order as $item){ ?>
                        <tr>
                            <td class="right"><?php echo $item['order_id']; ?></td>
                            <td class="left"><?php echo $item['order_customer_username']; ?></td>
                            <td class="left"><?php echo date('d/m/Y H:i:s', $item['order_add_date_time_int']); ?></td>
                            <td class="right"><?php echo $item['order_price']; ?></td>
                            <td class="right">
                                <a title="Sửa" href="admin.php#customer/order_edit?order_id=<?php echo $item['order_id']; ?>" target="_blank"><span class=" wrapper color-icons pencil_co"></span></a>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>