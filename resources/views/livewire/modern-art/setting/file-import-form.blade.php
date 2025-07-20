<div class="m-4 mb-3 flex justify-center">
    <section class="bg-base-100 w-full md:w-9/12 p-4 shadow shadow-slate-500 ">
        <h1 class="mb-6 text-xl text-slate-700">Import file</h1>

        <ul class="mb-4 list text-success italic pl-4">
            <li style="list-style: '- ';">Format file yang di upload harus berextension .csv</li>
            <li style="list-style: '- ';">File yang diupload tidak otomatis masuk transaksi, harus digenerate</li>
            <li style="list-style: '- ';">File yang digenerate akan gagal jika tidak sesuai dengan format</li>
        </ul>

        <div class="mb-4">
            <input type="file" class="file-input w-full input-sm md:input-md" />
        </div>

        <div class="mb-4 flex justify-end gap-2">
            <button type="button" wire:click="doDownload" class="btn btn-sm btn-info">Download file format</button>

            <button class="btn btn-sm btn-primary">Upload</button>
        </div>

        <div class="divider divider-sm"></div>

        <div>
            <ul class="list bg-base-100 rounded-box shadow-md">

                <li class="p-4 pb-2 text-sm tracking-wide opacity-60 italic">File hasil upload</li>

                @for ($i = 0; $i < 10; $i++)
                    <li class="list-row flex gap-2 border border-slate-300 mb-2">
                        <div class="basis-10/12">
                            <div class="text-md font-semibold">File upload</div>
                            <div class="text-sm italic text-primary">File belum digenerate</div>
                            <div class="text-xs opacity-70 italic">Diupload pada 13:11, 10 januari 2024</div>
                        </div>

                        <div class="basis-1/12 flex justify-center items-end">
                            <button class="btn btn-xs btn-info w-full">Download</button>
                        </div>

                        <div class="basis-1/12 flex justify-center items-end">
                            <button class="btn btn-xs btn-primary w-full">Generate</button>
                        </div>
                    </li>
                @endfor
            </ul>
        </div>

    </section>
</div>
