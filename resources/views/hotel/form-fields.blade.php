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
    <label for="form-hotel-brand_color_primary">{{ __('Brand_color_primary') }}</label>
    <input id="form-hotel-brand_color_primary"
        value="{{ old('brand_color_primary', isset($hotel->brand_color_primary) ? $hotel->brand_color_primary : null) }}"
        type="color"
        name="brand_color_primary">
</div>
<div class="form-group">
    <label for="form-hotel-brand_color_accent">{{ __('Brand_color_accent') }}</label>
    <input id="form-hotel-brand_color_accent"
        value="{{ old('brand_color_accent', isset($hotel->brand_color_accent) ? $hotel->brand_color_accent : null) }}"
        type="color"
        name="brand_color_accent">
</div>
<div class="form-group">
    <label for="form-hotel-brand_logo">{{ __('Brand_logo') }}</label>
    <input id="form-hotel-brand_logo"
        value="{{ old('brand_logo') }}"
        type="file"
        name="brand_logo">
</div>
<div class="form-group">
    <label for="form-hotel-brand_icon">{{ __('Brand_icon') }}</label>
    <input id="form-hotel-brand_icon"
        value="{{ old('brand_icon') }}"
        type="file"
        name="brand_icon">
</div>
<div class="form-group">
    <label for="form-hotel-website">{{ __('Website') }}</label>
    <input id="form-hotel-website"
        value="{{ old('website', isset($hotel->website) ? $hotel->website : null) }}"
        type="url"
        name="website">
</div>
<div class="form-group">
    <label for="form-hotel-contact_phone">{{ __('Contact_phone') }}</label>
    <input id="form-hotel-contact_phone"
        value="{{ old('contact_phone', isset($hotel->contact_phone) ? $hotel->contact_phone : null) }}"
        type="tel"
        name="contact_phone">
</div>
<div class="form-group">
    <label for="form-hotel-contact_email">{{ __('Contact_email') }}</label>
    <input id="form-hotel-contact_email"
        value="{{ old('contact_email', isset($hotel->contact_email) ? $hotel->contact_email : null) }}"
        type="email"
        name="contact_email">
</div>
<div class="form-group">
    <label for="form-hotel-address_street">{{ __('Address_street') }}</label>
    <input id="form-hotel-address_street"
        value="{{ old('address_street', isset($hotel->address_street) ? $hotel->address_street : null) }}"
        type="text"
        name="address_street">
</div>
<div class="form-group">
    <label for="form-hotel-address_city">{{ __('Address_city') }}</label>
    <input id="form-hotel-address_city"
        value="{{ old('address_city', isset($hotel->address_city) ? $hotel->address_city : null) }}"
        type="text"
        name="address_city">
</div>
<div class="form-group">
    <label for="form-hotel-address_zip">{{ __('Address_zip') }}</label>
    <input id="form-hotel-address_zip"
        value="{{ old('address_zip', isset($hotel->address_zip) ? $hotel->address_zip : null) }}"
        type="text"
        name="address_zip">
</div>
<div class="form-group">
    <label for="form-hotel-address_lat">{{ __('Address_lat') }}</label>
    <input id="form-hotel-address_lat"
        value="{{ old('address_lat', isset($hotel->address_lat) ? $hotel->address_lat : null) }}"
        type="text"
        name="address_lat">
</div>
<div class="form-group">
    <label for="form-hotel-address_lon">{{ __('Address_lon') }}</label>
    <input id="form-hotel-address_lon"
        value="{{ old('address_lon', isset($hotel->address_lon) ? $hotel->address_lon : null) }}"
        type="text"
        name="address_lon">
</div>