<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Game;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GameResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GameResource\RelationManagers;


class GameResource extends Resource
{
    protected static ?string $model = Game::class;
    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';
    protected static ?string $navigationGroup = 'Games & Reviews';
    protected static ?string $recordTitleAttribute = 'title';
    
    
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Game Information')
            ->description('Put the game information here')
            ->schema([
                TextInput::make('title')
                ->placeholder('Game Name')
                ->label('Game Title')
                ->required(),
                DatePicker::make('release_date')
                ->required(),
                TextInput::make('price')
                ->placeholder('99000')
                ->numeric()
                ->required(),
                ])->columns(3),
                
                Section::make('Metadata')
                ->description('Put the game data here')
                ->schema([
                    Select::make('category_id')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->relationship('category','category_name'),
                    Select::make('developer_id')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->relationship('developer','developer_name'),
                    FileUpload::make('cover')
                    ->required()
                    ->columnSpanFull(),
                    ])->columns(2)
                ]);
            }
            
            public static function table(Table $table): Table
            {
                return $table
                ->columns([
                    ImageColumn::make('cover')
                    ->toggleable(),
                    TextColumn::make('title')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                    TextColumn::make('release_date')
                    ->toggleable()
                    ->date()
                    ->sortable(),
                    TextColumn::make('price')
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->money('IDR'),
                    TextColumn::make('category.category_name')
                    ->toggleable(),
                    TextColumn::make('developer.developer_name')
                    ->toggleable(),
                    ])
                    ->filters([
                        //
                        ])
                        ->actions([
                            Tables\Actions\ViewAction::make(),
                            Tables\Actions\EditAction::make(),
                            Tables\Actions\DeleteAction::make(),
                            ])
                            ->bulkActions([
                                Tables\Actions\BulkActionGroup::make([
                                    Tables\Actions\DeleteBulkAction::make(),
                                ]),
                                ])
                                ->emptyStateActions([
                                    Tables\Actions\CreateAction::make(),
                                ]);
                            }
                            
                            public static function infolist(Infolist $infolist): Infolist
                            {
                                return $infolist
                                ->schema([
                                    ImageEntry::make('cover'),
                                    TextEntry::make('title'),
                                    TextEntry::make('price')
                                    ->money('IDR'),
                                    TextEntry::make('release_date')
                                    ->date(),
                                    TextEntry::make('category.category_name'),
                                    TextEntry::make('developer.developer_name'),

                                ])->columns(2);
                            }
                            
                            public static function getRelations(): array
                            {
                                return [
                                    //
                                ];
                            }
                            
                            public static function getPages(): array
                            {
                                return [
                                    'index' => Pages\ListGames::route('/'),
                                    'create' => Pages\CreateGame::route('/create'),
                                    'edit' => Pages\EditGame::route('/{record}/edit'),
                                ];
                            }    
                        }
                        