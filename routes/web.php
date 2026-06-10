    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProfileController;

    /*
    |--------------------------------------------------------------------------
    | CONTROLLERS
    |--------------------------------------------------------------------------
    */

    /* SISWA */
    use App\Http\Controllers\Siswa\SiswaCourseController;
    use App\Http\Controllers\Siswa\SiswaMateriController;
    use App\Http\Controllers\Siswa\SiswaOrientasiController;
    use App\Http\Controllers\Siswa\SiswaLkpdController;
    use App\Http\Controllers\Siswa\SiswaSubmissionController;
    use App\Http\Controllers\Siswa\SiswaReflectionController;
    use App\Http\Controllers\Siswa\UjianController;
    use App\Http\Controllers\Siswa\DashboardSiswaController;
    use App\Http\Controllers\Siswa\SiswaCodeRunnerController;

    /* GURU */
    use App\Http\Controllers\Guru\CourseController;
    use App\Http\Controllers\Guru\MateriController;
    use App\Http\Controllers\Guru\DashboardGuruController;
    use App\Http\Controllers\Guru\OrientasiController;
    use App\Http\Controllers\Guru\LkpdController;
    use App\Http\Controllers\Guru\GuruUserController;
    use App\Http\Controllers\Guru\BankSoalController;
    use App\Http\Controllers\Guru\NilaiController;
    use App\Http\Controllers\Guru\ReflectionQuestionController;



    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    Route::get('/', fn () => view('welcome'))->name('home');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD GLOBAL
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->get('/dashboard', function () {

        return match(auth()->user()->role) {
            'guru' => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => abort(403)
        };

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->group(function () {

        Route::controller(ProfileController::class)->group(function () {

            Route::get('/profile','edit')->name('profile.edit');
            Route::patch('/profile','update')->name('profile.update');
            Route::delete('/profile','destroy')->name('profile.destroy');

        });

    });


    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth','role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function(){

        /*
        | Dashboard
        */
    Route::get('/dashboard',[DashboardSiswaController::class,'index'])
        ->name('dashboard');


        /*
        | COURSE
        */
        Route::prefix('course')
        ->name('course.')
        ->controller(SiswaCourseController::class)
        ->group(function(){

            Route::get('/','index')->name('index');
            Route::get('/{course}','show')->name('show');


        });


        /*
        | ORIENTASI
        */
        Route::controller(SiswaOrientasiController::class)
        ->prefix('course/{course}/orientasi')
        ->name('course.orientasi.')
        ->group(function(){

            Route::get('/','show')->name('show');
            Route::post('/','simpanJawaban')->name('simpanJawaban');

        });

        /*
        | LKPD
        */
        Route::controller(SiswaLkpdController::class)
        ->prefix('course/{course}/lkpd')
        ->name('course.lkpd.')
        ->group(function(){

            Route::get('/awal','lkpdAwal')->name('awal');
            Route::get('/lanjutan','lkpdLanjutan')->name('lanjutan');
            Route::get('presentasi','presentasi')->name('presentasi');

            Route::post('/store','store')->name('store');
            Route::post('/pilih-kasus', 'pilihKasus')->name('pilihKasus');

            Route::post('/presentasi/store','storePresentation')->name('presentasi.store');


        });


        /*
        | MATERI
        */
        Route::get(
            'course/{course}/materi/{step?}',
            [SiswaMateriController::class,'index']
        )->name('course.materi');
        Route::post(
            'course/{course}/materi/selesai',
            [SiswaMateriController::class, 'selesai']
        )->name('course.materi.selesai');
        Route::post(
            'course/{course}/materi/abstraksi',
            [SiswaMateriController::class,'simpanAbstraksi']
        )->name('course.materi.abstraksi');


        /*
        | CODE RUNNER
        */
        Route::get(
            'course/{course}/code-runner',
            [SiswaCodeRunnerController::class,'index']
        )->name('course.code-runner');


        /*
        | SUBMISSION
        */
        Route::controller(SiswaSubmissionController::class)
        ->prefix('course/{course}/submit')
        ->name('course.submit.')
        ->group(function(){

            Route::get('/','create')->name('create');
            Route::post('/','store')->name('store');

        });


        /*
        | REFLECTION
        */
        Route::controller(SiswaReflectionController::class)
        ->prefix('course/{course}/reflection')
        ->name('course.reflection.')
        ->group(function(){

            Route::get('/','index')->name('index');
            Route::post('/store','store')->name('store');

        });


        /*
        | PRETEST & POSTTEST
        */
       Route::controller(UjianController::class)->group(function(){

            Route::get('/pretest','pretest')->name('pretest');
            Route::get('/pretest/start','startPretest')->name('pretest.start');
            Route::post('/pretest/submit','submitPretest')->name('pretest.submit');

            Route::get('/posttest','posttest')->name('posttest');
            Route::get('/posttest/start','startPosttest')->name('posttest.start');
            Route::post('/posttest/submit','submitPosttest')->name('posttest.submit');

            // 🔥 INI SAJA
            Route::get('/{jenis}/hasil','hasil')->name('hasil');

        });
    });



    /*
    |--------------------------------------------------------------------------
    | GURU
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth','role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function(){

        /*
        | Dashboard
        */
        Route::get('/dashboard',[DashboardGuruController::class,'index'])
        ->name('dashboard');


        Route::controller(GuruUserController::class)
        ->prefix('user')
        ->name('user.')
        ->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');

    });

        /*
        | COURSE CRUD
        */
        Route::resource('course',CourseController::class);


        /*
        | PER COURSE
        */
        Route::prefix('course/{course}')
        ->group(function(){

            /*
            | ORIENTASI
            */
            Route::controller(OrientasiController::class)
            ->prefix('orientasi')
            ->name('orientasi.')
            ->group(function(){

                Route::get('create','create')->name('create');
                Route::post('/','store')->name('store');


            });


            /*
            | LKPD
            */
            Route::controller(LkpdController::class)
            ->prefix('lkpd')
            ->name('lkpd.')
            ->group(function(){

                Route::get('create','create')->name('create');
                Route::post('/','store')->name('store');

                Route::get('/export/{courseId}','export')->name('export');
            });


            /*
            | REFLECTION QUESTION
            */
            Route::controller(ReflectionQuestionController::class)
            ->prefix('reflection')
            ->name('reflection.')
            ->group(function(){

                Route::get('create','create')->name('create');
                Route::post('/','store')->name('store');
                Route::get('{question}/edit','edit')->name('edit');
                Route::put('{question}','update')->name('update');
                Route::delete('{question}','destroy')->name('destroy');
                Route::get('answers','answers')->name('answers');



            });


            /*
            | MATERI
            */
            Route::controller(MateriController::class)
            ->prefix('materi')
            ->name('materi.')
            ->group(function(){

                Route::get('/','index')->name('index');
                Route::get('create','create')->name('create');
                Route::post('/','store')->name('store');

            });




        });


        /*
        | EDIT GLOBAL
        */

        Route::resource('orientasi',OrientasiController::class)
            ->only(['edit','update','destroy']);

        Route::resource('lkpd',LkpdController::class)
            ->only(['edit','update','destroy']);

        Route::resource('materi',MateriController::class)
            ->only(['edit','update','destroy']);


        /*
        | BANK SOAL
        */

        Route::controller(BankSoalController::class)
        ->prefix('bank-soal')
        ->name('bank_soal.')
        ->group(function(){

            Route::get('/','index')->name('index');
            Route::get('create/{jenis}','create')->name('create');
            Route::post('store','store')->name('store');
            Route::get('edit/{id}','edit')->name('edit');
            Route::put('update/{id}','update')->name('update');
            Route::delete('delete/{id}','destroy')->name('delete');

        });


        /*
        | NILAI
        */
    Route::prefix('nilai')
        ->name('nilai.')
        ->group(function(){

            // =========================
            // DASHBOARD NILAI
            // =========================
            Route::get('/', [NilaiController::class, 'index'])
                ->name('index');

            // =========================
            // detail prepost
            // =========================

            Route::get('/detail/{student}/{jenis}', [NilaiController::class, 'detailPrePost'])
            ->name('detail.prepost');

            // =========================
            // exel
            // =========================
        Route::get('export/{jenis}', [NilaiController::class, 'export'])
            ->name('export');

            // =========================
            // LKPD
            // =========================
            Route::get('rekap-lkpd', [NilaiController::class, 'rekapLkpd'])
                ->name('rekap.lkpd');

            Route::get('rekap-lkpd/{course}/{user}', [NilaiController::class, 'show'])
                ->name('rekap.show');

            // 🔥 SIMPAN NILAI LKPD
            Route::post('rekap-lkpd/save', [NilaiController::class, 'saveScore'])
                ->name('save');

        Route::post(
            'abstraction/save',
            [NilaiController::class, 'saveAbstraction']
        )->name('abstraction.save');

            // =========================
            // ORIENTASI
            // =========================
            Route::get('rekap-orientasi', [OrientasiController::class,'rekapOrientasi'])
                ->name('orientasi.rekap');

            Route::get('rekap-orientasi/{course}/{user}', [OrientasiController::class,'showRekapOrientasi'])
                ->name('rekap.orientasi.show');

            Route::post('rekap-orientasi/feedback',[OrientasiController::class,'saveFeedbackOrientasi'])
            ->name('orientasi.feedback');

            // =========================
            // REFLEKSI
            // =========================
            Route::get('rekap-refleksi', [ReflectionQuestionController::class,'rekapRefleksi'])
                ->name('rekap.refleksi');

            Route::get('rekap-refleksi/{course}/{user}', [ReflectionQuestionController::class,'showRekapRefleksi'])
                ->name('rekap.refleksi.show');

        });


        /*
        | SISWA
        */
        Route::view('/siswa','guru.siswa.index')
            ->name('siswa.index');

    });


    require __DIR__.'/auth.php';
