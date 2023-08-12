## Meetup Demo Snippets

Add this in AppServiceProvider.php
```php
Illuminate\Support\Facades\URL;

URL::forceScheme('https');
```
----------------------

#### DEMO-1

Contains
1. Simple CRUD

Branch: `demo-1` and `demo-2`

Todo
- Table Migration
```php
Schema::create('todos', function (Blueprint $table) {
    $table->id();
    $table->string('title', 100);
    $table->string('slug', 100);
    $table->text('description');
    $table->boolean('status')->default(false)->comment('0 - Pending, 1 - Completed');
    $table->tinyInteger('priority')->comment('0 - Very High, 1 - High, 2 - Medium, 3 - Low, 4 - Very Low');
    $table->timestamp('due_at')->nullable();
    $table->integer('created_by')->unsigned();
    $table->timestamps();
});
```
- fillable
```php
protected $fillable = [
    'title', 'slug', 'description', 'status', 'priority', 'due_at', 'created_by',
];

protected $casts = [
    'due_at' => 'timestamp',
    'status' => 'bool',
];
```

----------------------

#### DEMO-2

Branch: `demo-3` and `demo-4`

Contains
1. Global Search
2. Table Filters
3. Relationship manager > BelongsToMany
4. Display only user's leads when they login.

Property Schema

```php
Schema::create('properties', function (Blueprint $table) {
    $table->id();
    $table->string('name', 90);
    $table->string('location', 90);
    $table->decimal('price', 10, 2);
    $table->integer('bedrooms')->unsigned();
    $table->integer('bathrooms')->unsigned();
    $table->text('description');
    $table->timestamps();
});
```

- fillable
```php
protected $fillable = [
    'name', 'location', 'price', 'bedrooms', 'bathrooms', 'description',
];
```

Lead Schema

```php
Schema::create('leads', function (Blueprint $table) {
    $table->id();
    $table->integer('user_id')->unsigned();
    $table->string('lead_number', 30);
    $table->string('full_name', 60);
    $table->string('email', 80)->nullable();
    $table->string('phone_number', 15);
    $table->integer('property_type')->unsigned();
    $table->string('location', 90);
    $table->decimal('budget', 10, 2);
    $table->integer('bedrooms')->unsigned();
    $table->integer('bathrooms')->unsigned();
    $table->text('additional_requirements')->nullable();
    $table->timestamps();
});

Schema::create('lead_property', function (Blueprint $table) {
    $table->unsignedBigInteger('lead_id');
    $table->unsignedBigInteger('property_id');

    $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
    $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
});
```

- fillable

```php
protected $fillable = [
    'user_id', 'full_name', 'email', 'phone_number', 'property_type', 'location', 'budget', 'bedrooms', 'bathrooms',
    'additional_requirements',
];
```
