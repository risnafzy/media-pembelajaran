@extends('layouts.app')

@section('content')
    <div class="p-6">

        <form method="POST" action="{{ route('siswa.course.submit.store', $course->id) }}" enctype="multipart/form-data">

            @csrf

            <input type="file" name="file">

            <button class="bg-blue-500 text-white px-4 py-2">

                Submit

            </button>

        </form>

    </div>
@endsection
