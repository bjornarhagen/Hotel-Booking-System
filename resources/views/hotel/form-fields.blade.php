<fieldset>
    <legend>{{ __('Information') }}</legend>
    <div class="form-group">
        <label for="form-hotel-name">{{ __('Name') }}</label>
        <input id="form-hotel-name"
            value="{{ old('name', isset($hotel->name) ? $hotel->name : null) }}"
            type="text"
            name="name"
            required>
    </div>
    <div class="form-group">
        <label for="form-hotel-slug">{{ __('Slug') }}</label>
        <input id="form-hotel-slug"
            value="{{ old('slug', isset($hotel->slug) ? $hotel->slug : null) }}"
            type="text"
            name="slug">
    </div>
    <div class="form-group">
        <label for="form-hotel-description">{{ __('Description') }}</label>
        <textarea id="form-hotel-description"
            value="{{ old('description', isset($hotel->description) ? $hotel->description : null) }}"
            name="description"></textarea>
    </div>
    <div class="form-group">
        <label for="form-hotel-website">{{ __('Website') }}</label>
        <input id="form-hotel-website"
            value="{{ old('website', isset($hotel->website) ? $hotel->website : null) }}"
            type="url"
            name="website">
    </div>
    <div class="form-group">
        <label for="form-hotel-contact_phone">{{ __('Phone') }}</label>
        <input id="form-hotel-contact_phone"
            value="{{ old('contact_phone', isset($hotel->contact_phone) ? $hotel->contact_phone : null) }}"
            type="tel"
            name="contact_phone">
    </div>
    <div class="form-group">
        <label for="form-hotel-contact_email">{{ __('Email Address') }}</label>
        <input id="form-hotel-contact_email"
            value="{{ old('contact_email', isset($hotel->contact_email) ? $hotel->contact_email : null) }}"
            type="email"
            name="contact_email">
    </div>
</fieldset>
<fieldset>
    <legend>{{ __('Branding') }}</legend>
    <div class="form-group">
        <label for="form-hotel-brand_color_primary">{{ __('Primary color') }}</label>
        <input id="form-hotel-brand_color_primary"
            value="{{ old('brand_color_primary', isset($hotel->brand_color_primary) ? $hotel->brand_color_primary : null) }}"
            type="color"
            name="brand_color_primary">
    </div>
    <div class="form-group">
        <label for="form-hotel-brand_color_accent">{{ __('Accent color') }}</label>
        <input id="form-hotel-brand_color_accent"
            value="{{ old('brand_color_accent', isset($hotel->brand_color_accent) ? $hotel->brand_color_accent : null) }}"
            type="color"
            name="brand_color_accent">
    </div>
    <div class="form-group">
        <label for="form-hotel-brand_logo">{{ __('Logo') }}</label>
        <input id="form-hotel-brand_logo"
            value="{{ old('brand_logo') }}"
            type="file"
            name="brand_logo">
    </div>
    <div class="form-group">
        <label for="form-hotel-brand_icon">{{ __('Icon') }}</label>
        <input id="form-hotel-brand_icon"
            value="{{ old('brand_icon') }}"
            type="file"
            name="brand_icon">
    </div>
</fieldset>

<fieldset>
    <legend>{{ __('Address') }}</legend>
    <div class="form-group">
        <label for="form-hotel-address_street">{{ __('Streetname and number') }}</label>
        <input id="form-hotel-address_street"
            value="{{ old('address_street', isset($hotel->address_street) ? $hotel->address_street : null) }}"
            type="text"
            name="address_street"
            required>
    </div>
    <div class="form-group">
        <label for="form-hotel-address_city">{{ __('City') }}</label>
        <input id="form-hotel-address_city"
            value="{{ old('address_city', isset($hotel->address_city) ? $hotel->address_city : null) }}"
            type="text"
            name="address_city"
            required>
    </div>
    <div class="form-group">
        <label for="form-hotel-address_zip">{{ __('Postal code') }}</label>
        <input id="form-hotel-address_zip"
            value="{{ old('address_zip', isset($hotel->address_zip) ? $hotel->address_zip : null) }}"
            type="text"
            name="address_zip"
            required>
    </div>
    <div class="form-group">
        <label for="form-hotel-address_lat">{{ __('Latitude') }}</label>
        <input id="form-hotel-address_lat"
            value="{{ old('address_lat', isset($hotel->address_lat) ? $hotel->address_lat : null) }}"
            type="text"
            name="address_lat">
    </div>
    <div class="form-group">
        <label for="form-hotel-address_lon">{{ __('Longitude') }}</label>
        <input id="form-hotel-address_lon"
            value="{{ old('address_lon', isset($hotel->address_lon) ? $hotel->address_lon : null) }}"
            type="text"
            name="address_lon">
    </div>
</fieldset>
<fieldset>
    <legend>{{ __('Parking') }}</legend>
    <div class="form-group">
        <label for="form-hotel-parking_spots">{{ __('Spots') }}</label>
        <input id="form-hotel-parking_spots"
            value="{{ old('parking_spots', isset($hotel->parking_spots) ? $hotel->parking_spots : 0) }}"
            type="number"
            min="0"
            max="{{ pow(2, 32)-1 }}"
            name="parking_spots">
    </div>
    <div class="form-group">
        <label for="form-hotel-price_parking_spot">{{ __('Price per spot') }}</label>
        <input id="form-hotel-price_parking_spot"
            value="{{ old('price_parking_spot', isset($hotel->price_parking_spot) ? $hotel->price_parking_spot : 0) }}"
            type="number"
            min="0"
            max="{{ pow(2, 32)-1 }}"
            name="price_parking_spot">
    </div>
</fieldset>
<fieldset>
    <legend>{{ __('Meal prices (per day)') }}</legend>
    <div class="form-group">
        <label for="form-hotel-price_meal_breakfast">{{ __('Breakfast') }}</label>
        <input id="form-hotel-price_meal_breakfast"
            value="{{ old('price_meal_breakfast', isset($hotel->price_meal_breakfast) ? $hotel->price_meal_breakfast : null) }}"
            type="number"
            min="0"
            max="{{ pow(2, 32)-1 }}"
            name="price_meal_breakfast"
            required>
    </div>
    <div class="form-group">
        <label for="form-hotel-price_meal_lunch">{{ __('Lunch') }}</label>
        <input id="form-hotel-price_meal_lunch"
            value="{{ old('price_meal_lunch', isset($hotel->price_meal_lunch) ? $hotel->price_meal_lunch : null) }}"
            type="number"
            min="0"
            max="{{ pow(2, 32)-1 }}"
            name="price_meal_lunch"
            required>
    </div>
    <div class="form-group">
        <label for="form-hotel-price_meal_dinner">{{ __('Dinner') }}</label>
        <input id="form-hotel-price_meal_dinner"
            value="{{ old('price_meal_dinner', isset($hotel->price_meal_dinner) ? $hotel->price_meal_dinner : null) }}"
            type="number"
            min="0"
            max="{{ pow(2, 32)-1 }}"
            name="price_meal_dinner"
            required>
    </div>
</fieldset>