@extends('../layout/main')

@section('main')
    <section class="bg-base-200 py-2 px-4 m-4 rounded shadow">
        <div class="overflow-x-auto">
            <h1 class="text-2xl mb-4">Profile</h1>

            <table class="table mb-4 sm:w-6/12">
                <tbody>

                    <tr>
                        <td class="w-5/12">Nama</td>
                        <td class="w-1/12">:</td>
                        <td class="w-6/12">{{ auth()->user()->name }}</td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td class="w-6/12">{{ auth()->user()->email }}</td>
                    </tr>

                    <tr>
                        <td>Tanggal dibuat</td>
                        <td>:</td>
                        <td class="w-6/12">{{ date('j F Y', strtotime(auth()->user()->created_at)) }}</td>
                    </tr>

                </tbody>
            </table>

        </div>
    </section>
@endsection
