<section class="search-ticket-section padding-top pt-lg-0">
    <div class="container">
        <div class="search-tab bg_img" data-background=" {{asset('client/assets/images/ticket/ticket-bg01.jpg')}}">
            <div class="row align-items-center mb--20">
                <div class="col-lg-6 mb-20">
                    <div class="search-ticket-header">
                        <h6 class="category">Chào mừng đến với Xuân Thanh</h6>
                        <h3 class="title">Bạn đang tìm kiếm cái gì ?</h3>
                    </div>
                </div>
                <div class="col-lg-6 mb-20">
                    <ul class="tab-menu ticket-tab-menu">
                        <li class="active">
                            <div class="tab-thumb">
                                <img src="{{asset('client/assets/images/ticket/ticket-tab01.png')}}" alt="ticket">
                            </div>
                            <span>Sách</span>
                        </li>
                        <li>
                            <div class="tab-thumb">
                                <img src="{{asset('client/assets/images/ticket/ticket-tab02.png')}}" alt="ticket">
                            </div>
                            <span>Sự kiện</span>
                        </li>
                        <li>
                            <div class="tab-thumb">
                                <img src="{{asset('client/assets/images/ticket/ticket-tab03.png')}}" alt="ticket">
                            </div>
                            <span>Thể thao</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-area">
                <div class="tab-item active">
                    <form class="ticket-search-form" method="post">
                        @csrf
                        <div class="form-group large">
                            <input type="text" placeholder="Tìm kiếm phim" name="search_query">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{asset('client/assets/images/ticket/city.png ')}} " alt="ticket">
                            </div>
                            <span class="type">Thành phố</span>
                            <select class="select-bar">
                           
                                <option value=""></option>
                             
                            </select>

                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src=" {{asset('client/assets/images/ticket/date.png')}}" alt="ticket">
                            </div>
                            <span class="type">Ngày</span>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src=" {{asset('client/assets/images/ticket/cinema.png ')}}" alt="ticket">
                            </div>
                            <span class="type">Thư viện</span>
                            <select class="select-bar">
                             
                                <option value=""></option>
                             
                            </select>
                        </div>
                    </form>
                </div>
                <div class="tab-item">
                    <form class="ticket-search-form">
                        <div class="form-group large">
                            <input type="text" placeholder="Search fo Events">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src=" {{asset('client/assets/images/ticket/city.png ')}}" alt="ticket">
                            </div>
                            <span class="type">city</span>
                            <select class="select-bar">
                                <option value="london">London</option>
                                <option value="dhaka">dhaka</option>
                                <option value="rosario">rosario</option>
                                <option value="madrid">madrid</option>
                                <option value="koltaka">kolkata</option>
                                <option value="rome">rome</option>
                                <option value="khoksa">khoksa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{asset('client/assets/images/ticket/date.png ')}}" alt="ticket">
                            </div>
                            <span class="type">date</span>
                            <select class="select-bar">
                                <option value="26-12-19">23/10/2019</option>
                                <option value="26-12-19">24/10/2019</option>
                                <option value="26-12-19">25/10/2019</option>
                                <option value="26-12-19">26/10/2019</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src=" {{asset('client/assets/images/ticket/cinema.png ')}}" alt="ticket">
                            </div>
                            <span class="type">event</span>
                            <select class="select-bar">
                                <option value="angular">angular</option>
                                <option value="startup">startup</option>
                                <option value="rosario">rosario</option>
                                <option value="madrid">madrid</option>
                                <option value="koltaka">kolkata</option>
                                <option value="Last-First">Last-First</option>
                                <option value="wish">wish</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="tab-item">
                    <form class="ticket-search-form">
                        <div class="form-group large">
                            <input type="text" placeholder="Search fo Sports">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{asset('client/assets/images/ticket/city.png ')}}" alt="ticket">
                            </div>
                            <span class="type">thành phố</span>
                            <select class="select-bar">
                                <option value="london">London</option>
                                <option value="dhaka">dhaka</option>
                                <option value="rosario">rosario</option>
                                <option value="madrid">madrid</option>
                                <option value="koltaka">kolkata</option>
                                <option value="rome">rome</option>
                                <option value="khoksa">khoksa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src=" {{asset('client/assets/images/ticket/date.png ')}}" alt="ticket">
                            </div>
                            <span class="type">ngày</span>
                            <select class="select-bar">
                                <option value="26-12-19">23/10/2019</option>
                                <option value="26-12-19">24/10/2019</option>
                                <option value="26-12-19">25/10/2019</option>
                                <option value="26-12-19">26/10/2019</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src=" {{asset('client/assets/images/ticket/cinema.png ')}}" alt="ticket">
                            </div>
                            <span class="type">thể thao</span>
                            <select class="select-bar">
                                <option value="football">football</option>
                                <option value="cricket">cricket</option>
                                <option value="cabadi">cabadi</option>
                                <option value="madrid">madrid</option>
                                <option value="gadon">gadon</option>
                                <option value="rome">rome</option>
                                <option value="khoksa">khoksa</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
