<div class="table-responsive scroll_wrap">
    <table class="table position-relative personnel-table scroll_me">
        <thead>
        <tr class="tb-head text-uppercase blue-d-t text-center">
            <th scope="col" class="h-60">
                <div class="d-block h-100 p-3 radius-top-left border-left border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                    id
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block h-100 p-3  border-top border-bottom border-blue text-nowrap dark-link text-nowrap">
                    online
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                    имя фамилия
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap">
                    должность
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                    email
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">
                    телефон
                </div>
            </th>
            <th scope="col" class="h-60">
                <div class="d-block p-3 h-100 border-top border-bottom border-blue dark-link text-nowrap radius-top-right border-right">
                    действия
                </div>
            </th>
        </tr>
        </thead>

        <tbody id="personnel-place" class="table-bg">

        @include('admin.users.layouts.personnel.layouts.userItem')

        </tbody>
    </table>
</div>


