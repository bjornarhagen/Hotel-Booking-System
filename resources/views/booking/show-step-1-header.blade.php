<header class="page-header">
    <div class="page-header-overlay"></div>
    <div class="page-header-background"></div>
    <div id="page-navigation-padding"></div>
    <div class="page-header-content">
        <h1 class="page-title entry-title">{{ $hotel->name }}</h1>
        <p class="page-description">{{ $hotel->address }}</p>

        @php
        // 01-31
        $regex_days = '0*([1-9]|[12][0-9]|3[01])';

        // 01-12
        $regex_months = '0*([1-9]|1[0-2])';

        // Min = this year
        // Max = next year
        $min_year = date('Y');
        $max_year = (string)((int)date('Y') + 1);

        // Generate regex for min and max year
        // Example output (2019-2020): ([2]{1}[0]{1}[1]{1}[9]{1})|([2]{1}[0]{1}[2]{1}[0]{1})
        $regex_years = '(';
        for ($i = 0; $i < strlen($min_year); $i++) {
            $regex_years .= '[' . $min_year[$i] . ']{1}';
        }

        $regex_years .= ')|(';

        for ($i = 0; $i < strlen($max_year); $i++) {
            $regex_years .= '[' . $max_year[$i] . ']{1}';
        }
        $regex_years .= ')';

        // Booking info link
        $target_string = '';
        if (!empty($booking_info_link['target'])) {
            $target_string = ' target="' . $booking_info_link['target'] . '"';
            $target_string .= ' noopener';
        }
        @endphp

        <section id="booking-form-wrapper">
            @if (!empty($booking_info_text))
                <p class="booking-form-intro-text">
                    <span>{{ $booking_info_text }}</span>

                    <a href="{{ $booking_info_link['url'] }}" {{ $target_string }}>
                        <span>{{ $booking_info_link['title'] }}</span>
                        @icon('chevron-right')
                    </a>
                </p>
            @endif

            <datalist id="days-list">
                @for ($i = 1; $i <= 31; $i++) }}
                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"></option>
                @endfor
            </datalist>

            <datalist id="months-list">
                @for ($i = 1; $i <= 12; $i++) : }}
                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"></option>
                @endfor
            </datalist>

            <datalist id="years-list">
                <option value="{{ $min_year }}"></option>
                <option value="{{ $max_year }}"></option>
            </datalist>

            <form id="booking-form" action="{{ route('hotel.booking.step-2', $hotel->slug) }}" method="get">
                <div class="form-group form-group-line">
                    <label for="">
                        @icon('calendar')
                        <span>Innsjekk dato</span>
                    </label>
                    <div class="input input-date">
                        <input type="text" name="check_in_day" placeholder="Dag" list="days-list" required value="{{ old('check_in_day', $check_in_day) }}" maxlength="2" pattern="{{ $regex_days }}" autocomplete="off">
                        <input type="text" name="check_in_month" placeholder="Måned" list="months-list" required value="{{ old('check_in_month', $check_in_month) }}" maxlength="2" pattern="{{ $regex_months }}" autocomplete="off">
                        <input type="text" name="check_in_year" placeholder="År" list="years-list" required value="{{ old('check_in_year', $check_in_year ? $check_in_year : date('Y')) }}" maxlength="4" pattern="{{ $regex_years }}" autocomplete="off">
                    </div>
                </div>

                <div class="form-group form-group-line">
                    <label for="">
                        @icon('calendar')
                        <span>Utsjekk dato</span>
                    </label>
                    <div class="input input-date">
                        <input type="text" name="check_out_day" placeholder="Dag" list="days-list" required value="{{ old('check_out_day', $check_out_day) }}" maxlength="2" pattern="{{ $regex_days }}" autocomplete="off">
                        <input type="text" name="check_out_month" placeholder="Måned" list="months-list" required value="{{ old('check_out_month', $check_out_month) }}" maxlength="2" pattern="{{ $regex_months }}" autocomplete="off">
                        <input type="text" name="check_out_year" placeholder="År" list="years-list" required value="{{ old('check_out_year', $check_out_year ? $check_out_year : date('Y')) }}" maxlength="4" pattern="{{ $regex_years }}" autocomplete="off">
                    </div>
                </div>

                <div class="form-group form-group-line">
                    <label for="">
                        @icon('people')
                        <span>Antall personer</span>
                    </label>
                    <div class="input input-select">
                        <select id="" name="people" required>
                            <option value="" selected disabled hidden>Antall personer</option>
                            @for ($i = 1; $i <= 15; $i++) : }}
                                @if (old('people', $people) == $i)
                                    <option value="{{ $i }}" selected>{{ $i }}</option>
                                @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-submit">
                    <div class="input">
                        <button class="button-primary" type="submit">Finn rom</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</header>