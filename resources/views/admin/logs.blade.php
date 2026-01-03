<div class="p-6 bg-white rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Journal des activités</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-4 font-semibold text-gray-700">Utilisateur</th>
                    <th class="p-4 font-semibold text-gray-700">Action</th>
                    <th class="p-4 font-semibold text-gray-700">Description</th>
                    <th class="p-4 font-semibold text-gray-700">IP</th>
                    <th class="p-4 font-semibold text-gray-700">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4">
                        <span class="font-medium">{{ $log->user->name ?? 'Invité' }}</span>
                        <p class="text-xs text-gray-500">{{ $log->user->email ?? '' }}</p>
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-xs font-bold
                            {{ $log->action == 'Connexion' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="p-4 text-sm text-gray-600">{{ $log->description }}</td>
                    <td class="p-4 text-xs text-mono text-gray-400">{{ $log->ip_address }}</td>
                    <td class="p-4 text-sm text-gray-600">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4">
                        <div class="flex items-center">
                            <img src="https://flagcdn.com/w20/{{ strtolower($log->code_pays) }}.png" class="mr-2 shadow-sm">
                            <span class="text-sm font-semibold">{{ $log->ville }}, {{ $log->pays }}</span>
                        </div>
                        <p class="text-[10px] text-gray-400">GPS: {{ $log->latitude }}, {{ $log->longitude }}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
