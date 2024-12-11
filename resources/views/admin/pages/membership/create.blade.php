@extends('admin.admin_master')
@section('title')
    Membership Form
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Boi Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('save-membership') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div>
                                            <label for="basiInput" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="lastname"
                                                placeholder="Surname">
                                            @error('lastname')
                                                <span class="badge badge-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="labelInput" class="form-label">Othernames</label>
                                            <input type="text" class="form-control" name="othernames"
                                                placeholder="Othernames">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name"
                                                placeholder="First Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div>
                                            <label for="basiInput" class="form-label">Date of Birth </label>
                                            <input type="date" class="form-control" name="dob">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="labelInput" class="form-label">Gender</label>
                                            <select class="form-select" name="gender">
                                                <option selected="">Choose...</option>
                                                <option value="MALE">MALE</option>
                                                <option value="FEMALE">FEMALE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Marital Status</label>
                                            <select class="form-select" name="marital_status">
                                                <option selected="">Choose...</option>
                                                <option value="SINGLE">SINGLE</option>
                                                <option value="MARRIED">MARRIED</option>
                                                <option value="DIVORCED">DIVORCED</option>
                                                <option value="SEPERATED">SEPERATED</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div>
                                            <label for="basiInput" class="form-label">Tribe</label>
                                            <select class="form-select" name="tribe">
                                                <option selected="">Choose...</option>
                                                @foreach ($tribes as $list)
                                                    <option value="{{ $list->id }}">{{ $list->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="district" class="form-label">Hometown District</label>
                                            <select class="form-select" id="district" name="hometown_district">
                                                <option selected="">Choose...</option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}">{{ $district->district_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div>
                                            <label for="region" class="form-label">Hometown Region</label>
                                            <select class="form-select" id="region" name="hometown_region">
                                                <option selected="">Choose...</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Educational
                                                Background</label>
                                            <select class="form-select" name="educational_background">
                                                <option selected="">Choose...</option>
                                                <option value="NONE">NONE</option>
                                                <option value="A LEVEL">A LEVEL</option>
                                                <option value="JUNIOR HIGH SCHOOL">JUNIOR HIGH SCHOOL</option>
                                                <option value="SENIOR HIGH SCHOOL">SENIOR HIGH SCHOOL</option>
                                                <option value="TERTIARY">TERTIARY</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Occupation</label>
                                            <input type="text" class="form-control" name="occupation"
                                                placeholder="Placeholder">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="bloodGroup" class="form-label">Blood Group</label>
                                            <select class="form-select" id="bloodGroup" name="blood_group">
                                                <option selected="">Choose...</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="sickleCell" class="form-label">Sickle Cell Type</label>
                                            <select class="form-select" id="sickleCell" name="sickcell_type">
                                                <option selected="">Choose...</option>
                                                <option value="AA">AA</option>
                                                <option value="AS">AS</option>
                                                <option value="SS">SS</option>
                                                <option value="SC">SC</option>
                                                <option value="AC">AC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                <option>Choose...</option>
                                                <option value="PASTOR">PASTOR</option>
                                                <option value="LEADER">LEADER</option>
                                                <option value="MEMBER">MEMBER</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="churchTitle" class="form-label">Church Title</label>
                                            <select class="form-select" id="churchTitle" name="title">
                                                <option>CHOOSE...</option>
                                                <option value="PASTOR">PASTOR</option>
                                                <option value="BISHOP">BISHOP</option>
                                                <option value="DEACON">DEACON</option>
                                                <option value="ELDER">ELDER</option>
                                                <option value="REVEREND">REVEREND</option>
                                                <option value="APOSTLE">APOSTLE</option>
                                                <option value="EVANGELIST">EVANGELIST</option>
                                                <option value="PROPHET">PROPHET</option>
                                                <option value="MINISTER">MINISTER</option>
                                                <option value="PRIEST">PRIEST</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                <h4>CONTACT INFO</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div>
                                            <label for="basiInput" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="labelInput" class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone"
                                                placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Secondary Phone</label>
                                            <input type="text" class="form-control" name="secondary_phone"
                                                placeholder="Secondary Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Residentail
                                                Address</label>
                                            <input type="text" class="form-control" name="residential_address"
                                                placeholder="Residential Address">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <h4 class="card-title text-center">Photo</h4>
                                <div class="input-block mb-3 d-flex justify-content-center">
                                    <div class="text-center">
                                        <img class="rounded-circle mt-5" id="showImage"
                                            src="{{ asset('membership_profile.png') }}" alt="Card image cap"
                                            style="width: 200px; height: 200px; object-fit: cover;">
                                        <input type="file" class="form-control mt-3" id="image"
                                            name="member_image">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success"> Add Membership</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#district').change(function() {
                var district_id = $(this).val();
                if (district_id) {
                    $('#region').prop('disabled', false);

                    $.ajax({
                        url: '/membership/get-regions/' + district_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#region').empty(); // Clear previous options
                            $('#region').append(
                                '<option value="">Choose...</option>'
                            ); // Add placeholder option

                            // Check if data is an array
                            if (Array.isArray(data) && data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#region').append('<option value="' + value.id +
                                        '">' + value.region_name + '</option>');
                                });
                            } else {
                                $('#region').append(
                                    '<option value="">No regions available</option>');
                            }
                        },
                        error: function(xhr) {
                            console.error("Error occurred: ", xhr); // Log any errors
                        }
                    });
                } else {
                    $('#region').empty().append('<option value="">Choose...</option>').prop('disabled',
                        true);
                }
            });
        });
    </script>
@endsection
