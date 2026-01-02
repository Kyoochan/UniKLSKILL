<div class="min-h-screen bg-gray-100 py-10 flex justify-center items-start">
    <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Icon sini</h1>
        <h1 class="text-2xl font-bold mb-4 text-center">Chtobt</h1>


        <div id="chatbox" class="h-80 overflow-y-auto border p-3 mb-4 rounded bg-gray-50">
            <div id="messages"></div>
        </div>

        <form id="faqForm" class="flex">
            <input type="text" id="question" name="question" placeholder="Ask a question..."
                class="flex-1 border rounded-l px-3 py-2 focus:outline-none" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700">
                Ask
            </button>
        </form>
    </div>

</div>
