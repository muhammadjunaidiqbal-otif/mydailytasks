<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Optional Styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        label {
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            border-radius: 6px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h2>Create New Category</h2>

    <form action="{{ route('categories-store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div>
            <label for="title">Title:</label>
            <input type="text" name="categoryTitle" id="title" required>
        </div>

        <!-- Slug -->
        <div>
            <label for="slug">Slug:</label>
            <input type="text" name="slug" id="slug" required>
        </div>

        <!-- Parent Category -->
        <div>
            <label for="parent_id">Parent Category:</label>
            <select name="parent_id" id="parent_id">
                <option value="">None</option>
                
                    <option value="1">hi</option>
                
            </select>
        </div>

        <!-- Description -->
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4"></textarea>
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image">Image:</label>
            <input type="file" name="attachment" id="image" accept="image/*">
        </div>

        <!-- Status -->
        <div>
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <!-- Submit -->
        <div>
            <button type="submit">Create Category</button>
        </div>
    </form>

</body>
</html>
