@extends('admin.admin_master')
@section('title')
    Edit Member
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Boi Data</h4>

                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('membership-table') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i>Back</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('update-membership', $member->uuid) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">

                                <div class="col-md-9">
                                    <h4>Member Information</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" name="lastname"
                                                    value="{{ $member->lastname }}">
                                                @error('lastname')
                                                    <span class="badge badge-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Othernames</label>
                                                <input type="text" class="form-control" name="othernames"
                                                    value="{{ $member->othernames }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" name="first_name"
                                                    value="{{ $member->first_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" name="dob"
                                                    value="{{ $member->dob }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Gender</label>
                                                <select class="form-select" name="gender">
                                                    <option value="MALE"
                                                        {{ $member->gender == 'MALE' ? 'selected' : '' }}>MALE</option>
                                                    <option value="FEMALE"
                                                        {{ $member->gender == 'FEMALE' ? 'selected' : '' }}>FEMALE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Marital Status</label>
                                                <select class="form-select" name="marital_status">
                                                    <option value="SINGLE"
                                                        {{ $member->marital_status == 'SINGLE' ? 'selected' : '' }}>SINGLE
                                                    </option>
                                                    <option value="MARRIED"
                                                        {{ $member->marital_status == 'MARRIED' ? 'selected' : '' }}>
                                                        MARRIED
                                                    </option>
                                                    <option value="DIVORCED"
                                                        {{ $member->marital_status == 'DIVORCED' ? 'selected' : '' }}>
                                                        DIVORCED</option>
                                                    <option value="SEPERATED"
                                                        {{ $member->marital_status == 'SEPERATED' ? 'selected' : '' }}>
                                                        SEPERATED</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Fields -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Tribe</label>
                                                <select class="form-select" name="tribe">
                                                    <option value="">Choose...</option>
                                                    @foreach ($tribes as $tribe)
                                                        <option value="{{ $tribe->id }}"
                                                            {{ $member->tribe == $tribe->id ? 'selected' : '' }}>
                                                            {{ $tribe->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Hometown District</label>
                                                <select class="form-select" name="hometown_district" id="district">
                                                    <option value="">Choose...</option>
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}"
                                                            {{ $member->hometown_district == $district->id ? 'selected' : '' }}>
                                                            {{ $district->district_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Hometown Region</label>
                                                <select class="form-select" name="hometown_region" id="region">
                                                    <option value="">Choose...</option>
                                                    @foreach ($regions as $region)
                                                        <option value="{{ $region->id }}"
                                                            {{ $member->hometown_region == $region->id ? 'selected' : '' }}>
                                                            {{ $region->region_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label for="educationalBackground" class="form-label">Educational
                                                    Background</label>
                                                <select class="form-select" id="educationalBackground"
                                                    name="educational_background" required>
                                                    <option value=""
                                                        {{ old('educational_background', $member->educational_background) == '' ? 'selected' : '' }}>
                                                        Choose...</option>
                                                    <option value="NONE"
                                                        {{ old('educational_background', $member->educational_background) == 'NONE' ? 'selected' : '' }}>
                                                        NONE</option>
                                                    <option value="A LEVEL"
                                                        {{ old('educational_background', $member->educational_background) == 'A LEVEL' ? 'selected' : '' }}>
                                                        A LEVEL</option>
                                                    <option value="JUNIOR HIGH SCHOOL"
                                                        {{ old('educational_background', $member->educational_background) == 'JUNIOR HIGH SCHOOL' ? 'selected' : '' }}>
                                                        JUNIOR HIGH SCHOOL</option>
                                                    <option value="SENIOR HIGH SCHOOL"
                                                        {{ old('educational_background', $member->educational_background) == 'SENIOR HIGH SCHOOL' ? 'selected' : '' }}>
                                                        SENIOR HIGH SCHOOL</option>
                                                    <option value="TERTIARY"
                                                        {{ old('educational_background', $member->educational_background) == 'TERTIARY' ? 'selected' : '' }}>
                                                        TERTIARY</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Occupation -->
                                        <div class="col-md-4">
                                            <div>
                                                <label for="occupation" class="form-label">Occupation</label>
                                                <input type="text" class="form-control" id="occupation" name="occupation"
                                                    placeholder="Enter your occupation"
                                                    value="{{ old('occupation', $member->occupation) }}" required>
                                            </div>
                                        </div>

                                        <!-- Blood Group -->
                                        <div class="col-md-4">
                                            <div>
                                                <label for="bloodGroup" class="form-label">Blood Group</label>
                                                <select class="form-select" id="bloodGroup" name="blood_group" required>
                                                    <option value=""
                                                        {{ old('blood_group', $member->blood_group) == '' ? 'selected' : '' }}>
                                                        Choose...</option>
                                                    <option value="A+"
                                                        {{ old('blood_group', $member->blood_group) == 'A+' ? 'selected' : '' }}>
                                                        A+</option>
                                                    <option value="A-"
                                                        {{ old('blood_group', $member->blood_group) == 'A-' ? 'selected' : '' }}>
                                                        A-</option>
                                                    <option value="B+"
                                                        {{ old('blood_group', $member->blood_group) == 'B+' ? 'selected' : '' }}>
                                                        B+</option>
                                                    <option value="B-"
                                                        {{ old('blood_group', $member->blood_group) == 'B-' ? 'selected' : '' }}>
                                                        B-</option>
                                                    <option value="AB+"
                                                        {{ old('blood_group', $member->blood_group) == 'AB+' ? 'selected' : '' }}>
                                                        AB+</option>
                                                    <option value="AB-"
                                                        {{ old('blood_group', $member->blood_group) == 'AB-' ? 'selected' : '' }}>
                                                        AB-</option>
                                                    <option value="O+"
                                                        {{ old('blood_group', $member->blood_group) == 'O+' ? 'selected' : '' }}>
                                                        O+</option>
                                                    <option value="O-"
                                                        {{ old('blood_group', $member->blood_group) == 'O-' ? 'selected' : '' }}>
                                                        O-</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Sickle Cell Type -->
                                        <div class="col-md-4">
                                            <div>
                                                <label for="sickleCell" class="form-label">Sickle Cell Type</label>
                                                <select class="form-select" id="sickleCell" name="sickcell_type"
                                                    required>
                                                    <option value=""
                                                        {{ old('sickcell_type', $member->sickcell_type) == '' ? 'selected' : '' }}>
                                                        Choose...</option>
                                                    <option value="AA"
                                                        {{ old('sickcell_type', $member->sickcell_type) == 'AA' ? 'selected' : '' }}>
                                                        AA</option>
                                                    <option value="AS"
                                                        {{ old('sickcell_type', $member->sickcell_type) == 'AS' ? 'selected' : '' }}>
                                                        AS</option>
                                                    <option value="SS"
                                                        {{ old('sickcell_type', $member->sickcell_type) == 'SS' ? 'selected' : '' }}>
                                                        SS</option>
                                                    <option value="SC"
                                                        {{ old('sickcell_type', $member->sickcell_type) == 'SC' ? 'selected' : '' }}>
                                                        SC</option>
                                                    <option value="AC"
                                                        {{ old('sickcell_type', $member->sickcell_type) == 'AC' ? 'selected' : '' }}>
                                                        AC</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-4">
                                            <div>
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value=""
                                                        {{ old('status', $member->status) == '' ? 'selected' : '' }}>
                                                        Choose...</option>
                                                    <option value="PASTOR"
                                                        {{ old('status', $member->status) == 'PASTOR' ? 'selected' : '' }}>
                                                        PASTOR</option>
                                                    <option value="LEADER"
                                                        {{ old('status', $member->status) == 'LEADER' ? 'selected' : '' }}>
                                                        LEADER</option>
                                                    <option value="MEMBER"
                                                        {{ old('status', $member->status) == 'MEMBER' ? 'selected' : '' }}>
                                                        MEMBER</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Church Title -->
                                        <div class="col-md-4">
                                            <div>
                                                <label for="churchTitle" class="form-label">Church Title</label>
                                                <select class="form-select" id="churchTitle" name="title" required>
                                                    <option value=""
                                                        {{ old('title', $member->title) == '' ? 'selected' : '' }}>
                                                        CHOOSE...</option>
                                                    <option value="PASTOR"
                                                        {{ old('title', $member->title) == 'PASTOR' ? 'selected' : '' }}>
                                                        PASTOR</option>
                                                    <option value="BISHOP"
                                                        {{ old('title', $member->title) == 'BISHOP' ? 'selected' : '' }}>
                                                        BISHOP</option>
                                                    <option value="DEACON"
                                                        {{ old('title', $member->title) == 'DEACON' ? 'selected' : '' }}>
                                                        DEACON</option>
                                                    <option value="ELDER"
                                                        {{ old('title', $member->title) == 'ELDER' ? 'selected' : '' }}>
                                                        ELDER</option>
                                                    <option value="REVEREND"
                                                        {{ old('title', $member->title) == 'REVEREND' ? 'selected' : '' }}>
                                                        REVEREND</option>
                                                    <option value="APOSTLE"
                                                        {{ old('title', $member->title) == 'APOSTLE' ? 'selected' : '' }}>
                                                        APOSTLE</option>
                                                    <option value="EVANGELIST"
                                                        {{ old('title', $member->title) == 'EVANGELIST' ? 'selected' : '' }}>
                                                        EVANGELIST</option>
                                                    <option value="PROPHET"
                                                        {{ old('title', $member->title) == 'PROPHET' ? 'selected' : '' }}>
                                                        PROPHET</option>
                                                    <option value="MINISTER"
                                                        {{ old('title', $member->title) == 'MINISTER' ? 'selected' : '' }}>
                                                        MINISTER</option>
                                                    <option value="PRIEST"
                                                        {{ old('title', $member->title) == 'PRIEST' ? 'selected' : '' }}>
                                                        PRIEST</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Info -->
                                    <hr>
                                    <h4>Contact Information</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ $member->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone"
                                                    value="{{ $member->phone }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label">Secondary Phone</label>
                                                <input type="text" class="form-control" name="secondary_phone"
                                                    value="{{ $member->secondary_phone }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <label class="form-label">Residential Address</label>
                                                <input type="text" class="form-control" name="residential_address"
                                                    value="{{ $member->residential_address }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column: Profile Picture -->
                                <div class="col-md-3">
                                    <h4 class="card-title text-center">Profile Picture</h4>
                                    <div class="input-block mb-3 d-flex justify-content-center">
                                        <div class="text-center">
                                            <img class="rounded-circle mt-5" id="showImage"
                                                src="{{ $member->member_image ? asset($member->member_image) : asset('membership_profile.png') }}"
                                                alt="Profile Picture"
                                                style="width: 200px; height: 200px; object-fit: cover;">
                                            <input type="file" class="form-control mt-3" id="image"
                                                name="member_image">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Update Membership</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        // Preview image before upload
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        // Load Regions dynamically
        $('#district').change(function() {
            var district_id = $(this).val();
            if (district_id) {
                $.ajax({
                    url: '/membership/get-regions/' + district_id,
                    type: 'GET',
                    success: function(data) {
                        $('#region').empty().append('<option value="">Choose...</option>');
                        data.forEach(region => {
                            $('#region').append('<option value="' + region.id + '">' + region
                                .region_name + '</option>');
                        });
                    }
                });
            }
        });
    </script>
@endsection
