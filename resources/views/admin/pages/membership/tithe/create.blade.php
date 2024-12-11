@extends('admin.admin_master')
@section('title')
    Tithe Payment
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ $member->lastname }} {{ $member->first_name }}
                        {{ $member->othernames }} (TITHE PAYMENT)</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('save-tithe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <label for="basiInput" class="form-label">Amount</label>
                                            <input type="text" class="form-control" name="amount" placeholder="amount">
                                            @error('amount')
                                                <span class="badge badge-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label for="labelInput" class="form-label">Remarks</label>
                                            <textarea rows="4" class="form-control" name="remarks">NTP</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success">Save Member Tithe</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
