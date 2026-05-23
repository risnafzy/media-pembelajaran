<h3>Jawaban Refleksi Siswa</h3>

@foreach ($questions as $q)
    <div class="card mb-3">

        <div class="card-header">


            {{ $q->pertanyaan }}

        </div>


        <div class="card-body">

            @foreach ($q->answers as $a)
                <div class="border p-2 mb-2">

                    Nama siswa:
                    <b>{{ $a->student->name }}</b>

                    <br>

                    Jawaban:
                    <br>

                    {{ $a->jawaban }}

                </div>
            @endforeach

        </div>

    </div>
@endforeach
