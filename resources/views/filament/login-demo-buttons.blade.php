<div class="space-y-3">
    <p class="text-center text-sm font-medium text-gray-500 dark:text-gray-400">Quick login as a demo role</p>

    <div class="grid grid-cols-2 gap-2" x-data="{
        fill(email, password) {
            $wire.set('data.email', email);
            $wire.set('data.password', password);
        }
    }">
        <button type="button"
            @click="fill('sarah@apexfleet.com', 'Apex!Admin2026#')"
            class="flex flex-col items-center gap-1 rounded-lg border border-amber-500/30 bg-amber-500/10 px-3 py-2.5 text-sm font-semibold text-amber-500 transition hover:bg-amber-500/20 hover:border-amber-500/50">
            <span>Admin</span>
            <span class="text-[11px] font-normal text-gray-400">Full access</span>
        </button>

        <button type="button"
            @click="fill('mike@apexfleet.com', 'Apex!Mgr2026#')"
            class="flex flex-col items-center gap-1 rounded-lg border border-sky-500/30 bg-sky-500/10 px-3 py-2.5 text-sm font-semibold text-sky-400 transition hover:bg-sky-500/20 hover:border-sky-500/50">
            <span>Manager</span>
            <span class="text-[11px] font-normal text-gray-400">No user mgmt</span>
        </button>

        <button type="button"
            @click="fill('jake@apexfleet.com', 'Apex!Tech2026#')"
            class="flex flex-col items-center gap-1 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-3 py-2.5 text-sm font-semibold text-emerald-400 transition hover:bg-emerald-500/20 hover:border-emerald-500/50">
            <span>Technician</span>
            <span class="text-[11px] font-normal text-gray-400">View + edit WOs</span>
        </button>

        <button type="button"
            @click="fill('emily@apexfleet.com', 'Apex!Drive2026#')"
            class="flex flex-col items-center gap-1 rounded-lg border border-purple-500/30 bg-purple-500/10 px-3 py-2.5 text-sm font-semibold text-purple-400 transition hover:bg-purple-500/20 hover:border-purple-500/50">
            <span>Driver</span>
            <span class="text-[11px] font-normal text-gray-400">View only</span>
        </button>
    </div>

    <div class="border-b border-gray-200 dark:border-gray-700"></div>
</div>
